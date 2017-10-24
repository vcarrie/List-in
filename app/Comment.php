<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdAccount($idAccount){
        return static::where('idAccount', '=', $idAccount);
    }
}
