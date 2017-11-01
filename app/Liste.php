<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdCreator($idCreator){
        return static::where('idCreator', '=', $idCreator);
    }



}


