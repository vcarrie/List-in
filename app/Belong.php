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

    public static function getProductsByIdList($idList, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct){
        $products_ids = static::getByIdList($idList)->get();
        $total = 0;

        $products = array();

        foreach ($products_ids as $product) {

            $list = $apiCdiscountSearchByIdProduct->searchWithIdProduct($product->idCdiscount);
            $quantity = $product->quantity;

            if(isset($list->Products[0]->BestOffer)){
                $total += $list->Products[0]->BestOffer->SalePrice * $quantity;
            }
            else{
                $total += 0;
            }

            $products[] = [$list, $quantity];

        }

        return [$products, $total];
    }

    public static function getProductsByIdsList($array_ids){

       return static::all()->whereIn('idList', $array_ids);

    }

    public static function deleteProductbyIdList($idList){

        self::getByIdList($idList)->delete();

    }
}
