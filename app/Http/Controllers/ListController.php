<?php

namespace App\Http\Controllers;

use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use App\Liste;
use App\Belong;
use App\Tag;
use App\Categorize;
use App\Account;

class ListController extends Controller
{

    public function getListsByIdAccount($id)
    {
        return Liste::getByIdCreator($id)->get();
    }

    public function getAllLists()
    {
        return Liste::all();
    }

    public function getListById($id, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct)
    {
        $products = Belong::getByIdList($id)->get();//Contains all the associated products ids
        $list = Liste::getByIdList($id)->get();
        $creator = Account::getByIdAccount($list[0]['idCreator'])->get();
        $Tags_ids = Categorize::getByIdList($id)->get();

        $Tags = array();
        foreach ($Tags_ids as $idTag){
            $Tags[] = Tag::getByIdTag($idTag['idTag'])->get();
        }
        $rawlistjson = [];

        foreach ($products as $product) {
            $rawlistjson[] = $apiCdiscountSearchByIdProduct->searchWithIdProduct($product->idCdiscount);
        }

        // we need to refactor the json to help its integration into the view
        $itemsjson = [];
        $totalprice = 0;
        foreach ($rawlistjson as $item) {
            $obj = $item->Products[0];

            $itemsjson[] = array(
                'Price' => $obj->BestOffer->SalePrice,
                'Name' => $obj->Name,
                'Description' => $obj->Description,
                'Image' => $obj->MainImageUrl
            );
            $totalprice += $obj->BestOffer->SalePrice;
        }

        $listjson = array(
            'Id' => $id,
            'Name' => $list[0]['listName'],
            'Description' => $list[0]['description'],
            'Creator' => $creator,
            'Tags' => $Tags,
            'TotalPrice' => $totalprice,
            'ItemAmount' => count($itemsjson),
            'Items' => $itemsjson
        );

        // popular tags for the searchbar...
        $top_5_ids = Categorize::top_5_most_used_tags();
        $tags_final_tab = Tag::getByIdsTag($top_5_ids);

        return view('list', compact('listjson', 'tags_final_tab'));
    }

}
