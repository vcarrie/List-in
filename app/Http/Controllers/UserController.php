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
        //return view('userProfile');
    }

    public function myAccount(){
        $user = Auth::user();

        return $user;
        //return view('userProfile');
    }
}
