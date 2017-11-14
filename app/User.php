<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pseudo', 'firstName', 'lastName', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',  'admin',
    ];

    public static function getByMail($mail){
        return static::where('mail', '=', $mail);
    }

    public static function email_exists($mail){
        $exists = false;
        if(self::getByMail($mail)){ $exists = true; }

        return $exists;
    }

    public function rates(){
        return $this->belongsToMany('App\Liste', 'rates', 'idUser', 'idList');
    }

    public function comments(){
        return $this->belongsToMany('App\Liste', 'comments', 'idUser', 'idList');
    }

    public function createdList(){
        return $this->hasMany('App\Liste', 'idCreator', 'id');
    }
}
