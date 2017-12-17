<?php

namespace App;

use App\Notifications\PwdValidatorNotification;
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
        'password', 'remember_token', 'admin',
    ];

    public static function getByMail($mail)
    {
        return static::where('email', '=', $mail);
    }

    public static function email_exists($mail)
    {
        if (sizeof(self::getByMail($mail)->get()) == 1) {
            return true;
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->admin; // this looks for an admin column in your users table
    }

    public function rates()
    {
        return $this->belongsToMany('App\Liste', 'rates', 'idUser', 'idList');
    }

    public function comments()
    {
        return $this->belongsToMany('App\Liste', 'comments', 'idUser', 'idList');
    }

    public function createdList()
    {
        return $this->hasMany('App\Liste', 'idCreator', 'id');
    }

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PwdValidatorNotification($token));
    }
}
