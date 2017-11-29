<?php

namespace App\Http\Controllers;

use App\Liste;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function panelAdmin(){

        $all_ids_list = Liste::all()->pluck('id');
        $all_ids_user = User::all()->pluck('id');
        $tab_final = array($all_ids_list, $all_ids_user);

        return view('panel-admin', compact('tab_final', 'tab_final'));
    }
}
