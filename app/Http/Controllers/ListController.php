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

    public function getListById($id, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct)
    {
        $list = Liste::find($id);

        $rawlistjson = Belong::getProductsByIdList($id, $apiCdiscountSearchByIdProduct);

        $itemsjson = [];
        $totalprice = 0;
        foreach ($rawlistjson as $item) {
            $obj = $item[0]->Products[0];

            $itemsjson[] = array(
                'Id' => $obj->Id,
                'Price' => str_replace('.',',',round($obj->BestOffer->SalePrice,2)),
                'Name' => $obj->Name,
                'Description' => $obj->Description,
                'Image' => $obj->MainImageUrl
            );
            $totalprice += $obj->BestOffer->SalePrice * $item[1];
        }

        $listjson = array(
            'list' => $list,
            'TotalPrice' => str_replace('.',',',round($totalprice,2)),
            'ItemAmount' => count($itemsjson),
            'Items' => $itemsjson
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

    public function validateCreateList(ValidateCreateListRequest $request, ValidateCreateListRepository $repository){
        $repository->createList($request);
    }

    public function deleteList($id){
        Belong::deleteProductbyIdList($id);
        Rate::deleteRateByIdList($id);
        Comment::deleteCommentbyIdList($id);
        Categorize::deleteCategorizeByIdList($id);

        Liste::find($id)->delete();

    }

}
