<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class Authentication extends Controller
{
    public function login(){
        $auth = "";
        return view('auth.connection', compact("auth", $auth ));
    }

    public function checkLogin(){

        $auth = Account::getByIdAccount(1)->get();
        //if($auth->mail() == )

        return view('auth.connection', compact("auth", $auth ));
    }

    public function register(){
        return view('auth.register');
    }
}
