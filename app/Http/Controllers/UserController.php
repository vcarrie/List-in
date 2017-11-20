<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);

        return $user;
    }

    public function myAccount(){
        $user = Auth::user();

        return view('account', compact($user));
    }
}
