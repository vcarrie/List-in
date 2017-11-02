<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public static function getByIdTag($idTag){
        return static::where('idTag', '=', $idTag);
    }


    public static function getByIdsTag($array_ids){
        return static::all()->whereIn('idTag', $array_ids);
    }


}
