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
        return static::where('idCdiscount', '=', $idCdiscount);
    }

    public static function createList($idList, $products, $quantities)
    {
        if (sizeof($products) == sizeof($quantities)){
            $sizeProducts = sizeof($products);

            for ($i = 0; $i < $sizeProducts; $i++) {
                $belong = new Belong;
                $belong->idList = $idList;
                $belong->idCdiscount = $products[$i];
                $belong->quantity = $quantities[$i];
                $belong->save();
                unset($belong);
            }
        }

    }

    public static function getTotalByIdList($idList, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct){
        $products_ids = static::getByIdList($idList)->get();
        $total = 0;
        foreach ($products_ids as $product) {
            $theprod = $apiCdiscountSearchByIdProduct->searchWithIdProduct($product->idCdiscount);

            if(isset($theprod->Products[0])){
                $total += $theprod->Products[0]->BestOffer->SalePrice * $product->quantity;
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

    public static function getProductsByIdsList($array_ids){

       $products = static::all()->whereIn('id', $array_ids)->get();


        return $products;
    }

    public static function deleteProductbyIdList($idList){

        self::getByIdList($idList)->delete();

    }
}
