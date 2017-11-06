<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public static function createList($idList, $products)
    {
        foreach ($products as $product) {
            $belong = new Belong;
            $belong->idList = $idList;
            $belong->idCdiscount = $product;
            $belong->save();
            unset($belong);
        }

    }
}
