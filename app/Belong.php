<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Belong extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdCdiscount($idCdiscount){
        return static::where('$idCdiscount', '=', $idCdiscount);
    }
}
