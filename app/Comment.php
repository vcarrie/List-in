<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdUser($idUser){
        return static::where('idUser', '=', $idUser);
    }

    public static function deleteCommentByIdList($idList){
        self::getByIdList($idList)->delete();
    }

    public static function deleteCommentByIdUser($idUser)
    {
        self::getByIdUser($idUser)->delete();
    }

    public function List(){
        return $this->belongsTo('App\List', 'idList');
    }

    public function User(){
        return $this->belongsTo('App\User', 'idUser');
    }
}
