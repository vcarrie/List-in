<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorize extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdTag($idTag){
        return static::where('$idTag', '=', $idTag);
    }
}
