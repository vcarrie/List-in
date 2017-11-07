<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Liste extends Model
{

    public static function getByIdCreator($idCreator){
        return static::where('idCreator', '=', $idCreator);
    }

    public static function getByIdsList($array){
        return static::all()->whereIn('id', $array);
    }

    public function tags(){
        return $this->belongsToMany("App\Tag", 'categorizes', 'idList', 'idTag');
    }

    public function commentedBy(){
        return $this->belongsToMany("App\User", 'comments', 'idList', 'idUser');
    }

    public function ratedBy(){
        return $this->belongsToMany("App\User", 'rates', 'idList', 'idUser');
    }

    public function creator(){
        return $this->belongsTo('App\User', 'idCreator');
    }

    public static function createList($name, $description, $idCreator){

        $list = new Liste;

        $list->listName = $name;
        $list->description = $description;
        $list->idCreator = $idCreator;

        $list->save();

        return $list->id;
    }

}


