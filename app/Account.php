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
}
