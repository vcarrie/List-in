<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    public static function getByMail($mail){
        return static::where('mail', '=', $mail);
    }

    public static function email_exists($mail){
        $exists = false;
        if(self::getByMail($mail)){ $exists = true; }

        return $exists;
    }

    public function rates(){
        return $this->belongsToMany('App\Liste', 'rates', 'idAccount', 'idList');
    }

    public function comments(){
        return $this->belongsToMany('App\Liste', 'comments', 'idAccount', 'idList');
    }

    public function createdList(){
        return $this->hasMany('App\Liste', 'idCreator', 'id');
    }

}
