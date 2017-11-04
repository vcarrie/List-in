<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{

    public static function getByIdCreator($idCreator){
        return static::where('idCreator', '=', $idCreator);
    }

    public function tags(){
        return $this->belongsToMany("App\Tag", 'categorizes', 'idList', 'idTag');
    }

    public function commentedBy(){
        return $this->belongsToMany("App\Account", 'comments', 'idList', 'idAccount');
    }

    public function ratedBy(){
        return $this->belongsToMany("App\Account", 'rates', 'idList', 'idAccount');
    }

    public function creator(){
        return $this->belongsTo('App\Account', 'idCreator');
    }

    public static function createList($name, $description, $idCreator){

        $list = new Liste;

        $list->listName = $name;
        $list->description = $description;
        $list->idCreator = $idCreator;

        $list->save();
    }

}


