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
        $list = Liste::find($id);
        $creator = $list->creator->get();
        $Tags = $list->tags;

        $rawlistjson = Belong::getProductsByIdList($id, $apiCdiscountSearchByIdProduct);

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

//        $listjson = array(
//            'Id' => $id,
//            'Name' => $list->listName,
//            'Description' => $list->description,
//            'Creator' => $creator,
//            'Tags' => $Tags,
//            'TotalPrice' => $totalprice,
//            'ItemAmount' => count($itemsjson),
//            'Items' => $itemsjson
//        );

        $listjson = array(
            'list' => $list,
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
