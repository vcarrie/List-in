<?php

namespace App\Http\Controllers;

use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use App\Liste;
use App\Belong;

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

        $json = [];
        $id = 0;

        foreach ($products as $product) {
            $json[$id] = $apiCdiscountSearchByIdProduct->searchWithIdProduct($product->idCdiscount);
            $id++;
        }

        return $json;
    }

}
