<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;

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

}


