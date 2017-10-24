<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static function getByIdProduct($idCdiscount){
        return static::where('idCdiscount', '=', $idCdiscount);
    }
}
