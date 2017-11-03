<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public static function getByIdAccount($idAccount){
        return static::where('idAccount', '=', $idAccount);
    }

    public static function getByMail($mail){
        return static::where('mail', '=', $mail);
    }

    public static function email_exists($mail){
        $exists = false;
        if(self::getByMail($mail)){ $exists = true; }

        return $exists;
    }

}
