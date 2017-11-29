<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\ValidateCreateListRequest;
use App\Rate;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use App\Liste;
use App\Belong;
use App\Repositories\Liste\ValidateCreateListRepository;
use App\Tag;
use App\Categorize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ListController extends Controller
{

    public function getListsByIdUser($id)
    {
        return Liste::getByIdCreator($id)->get();
    }

    public function getAllLists()
    {
        return Liste::all();
    }

    public function getListById($id, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct, Request $request)
    {
        $list = Liste::find($id);
        $comments = Comment::getByIdList($id)->orderBy('created_at', 'desc')->get();
        $rates = Rate::getByIdList($id)->get();
        $avg = Rate::averageForList($id);
        $user_rating = null;
        $listIsInCart = false;
        $session = array();;

        if (session()->has('cart')) {
            $session = session('cart');
        }

        if (Auth::check()) {
            if (count(Rate::getByIdListandListUser($id, Auth::user()->id)->get()) != 0) {
                $user_rating = Rate::getByIdListandListUser($id, Auth::user()->id)->first();
            }
        }

        foreach ($session as $key => $idList) {
            if ($id == $idList) {
                $listIsInCart = true;
            }
        }

        $rawlistjson = Belong::getProductsByIdList($id, $apiCdiscountSearchByIdProduct);

        $itemsjson = [];
        $totalprice = 0;
        foreach ($rawlistjson[0] as $item) {

            if (isset($item[0]->Products[0])) {

                $obj = $item[0]->Products[0];

                if (isset($item[0]->Products[0]->BestOffer)) {
                    $itemsjson[] = array(
                        'Id' => $obj->Id,
                        'Price' => str_replace('.', ',', round($obj->BestOffer->SalePrice, 2)),
                        'Name' => $obj->Name,
                        'Description' => $obj->Description,
                        'Image' => $obj->MainImageUrl,
                        'Quantity' => $item[1]
                    );
                    $totalprice += $obj->BestOffer->SalePrice * $item[1];
                } else {
                    $itemsjson[] = array(
                        'Id' => $obj->Id,
                        'Price' => 'Plus en stock !',
                        'Name' => $obj->Name,
                        'Description' => $obj->Description,
                        'Image' => $obj->MainImageUrl,
                        'Quantity' => 0
                    );
                }

            } else {
                $itemsjson[] = array(
                    'Id' => -1,
                    'Price' => 0,
                    'Name' => 'Article indisponible',
                    'Description' => '',
                    'Image' => '/images/dead.png',
                    'Quantity' => 0
                );
            }
        }


        $listjson = array(
            'list' => $list,
            'TotalPrice' => str_replace('.', ',', round($totalprice, 2)),
            'ItemAmount' => count($itemsjson),
            'Items' => $itemsjson,
            'Comments' => $comments,
            'Rates' => $rates,
            'Avg' => round($avg, 2),
            'userRating' => $user_rating,
            'listIsInCart' => $listIsInCart,
        );

        // popular tags for the searchbar...
        $top_5_ids = Categorize::top_5_most_used_tags();
        $tags_final_tab = Tag::getByIdsTag($top_5_ids);

        return view('list', compact('listjson', 'tags_final_tab'));

    }

    public function createList()
    {
        return view("create-list");
    }

    public function validateCreateList(ValidateCreateListRequest $request, ValidateCreateListRepository $repository)
    {
        $idList = $repository->createList($request);
        return redirect()->action('ListController@getListById', ['id' => $idList]);
    }

    public function deleteList($id)
    {
        Belong::deleteProductbyIdList($id);
        Rate::deleteRateByIdList($id);
        Comment::deleteCommentbyIdList($id);
        Categorize::deleteCategorizeByIdList($id);

        Liste::find($id)->delete();

        return redirect("/admin");

    }

    public function deleteUserList($id)
    {

        $list_is_of_user = false;
        $list_of_user = Auth::user()->createdList->pluck('id');
        foreach ($list_of_user as $item) {
            if ($item == $id) {
                $list_is_of_user = true;
            }
        }
        if (!$list_is_of_user) {
            return redirect('/account');
        }

        Belong::deleteProductbyIdList($id);
        Rate::deleteRateByIdList($id);
        Comment::deleteCommentbyIdList($id);
        Categorize::deleteCategorizeByIdList($id);

        Liste::find($id)->delete();

        return redirect("/account#account-section-3");

    }

}
