<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;

class Belong extends Model
{
    public static function getByIdList($idList)
    {
        return static::where('idList', '=', $idList);
    }

    public static function getByIdCdiscount($idCdiscount)
    {
        return static::where('$idCdiscount', '=', $idCdiscount);
    }

    public static function createList($idList, $products, $quantity)
    {
        foreach ($products as $product) {
            $belong = new Belong;
            $belong->idList = $idList;
            $belong->idCdiscount = $product;
            $belong->quantity = $quantity;
            $belong->save();
            unset($belong);
        }
    }

    public static function getTotalByIdList($idList, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct){
        $products_ids = static::getByIdList($idList)->get();
        $total = 0;
        foreach ($products_ids as $product) {
            $theprod = $apiCdiscountSearchByIdProduct->searchWithIdProduct($product->idCdiscount);

            if(isset($theprod->Products[0])){
                $total += $theprod->Products[0]->BestOffer->SalePrice * $products_ids->quantity;
            }
        }


        return $total;
    }

    public static function getProductsByIdList($idList, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct){
        $products_ids = static::getByIdList($idList)->get();
        $products = array();

        foreach ($products_ids as $product) {
            $products[] = [$apiCdiscountSearchByIdProduct->searchWithIdProduct($product->idCdiscount), $product->quantity];
        }


        return $products;
    }
}
