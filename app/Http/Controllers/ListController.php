<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCreateListRequest;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use App\Liste;
use App\Belong;
use App\Repositories\Liste\ValidateCreateListRepository;
use App\Tag;
use App\Categorize;
use App\User;

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
            $obj = $item->Products[0];

            $itemsjson[] = array(
                'Price' => $obj->BestOffer->SalePrice,
                'Id' => $obj->Id,
                'Price' => str_replace('.',',',round($obj->BestOffer->SalePrice,2)),
                'Name' => $obj->Name,
                'Description' => $obj->Description,
                'Image' => $obj->MainImageUrl
            );
            $totalprice += $obj->BestOffer->SalePrice;
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
        return view("createList");
    }

    public function validateCreateList(ValidateCreateListRequest $request, ValidateCreateListRepository $repository){
        $repository->createList($request);
    }

}
