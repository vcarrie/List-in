<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;


class HomeController extends Controller
{
    public function index(){
        $Tags = Tag::all()->toJson();
        return view('layouts.mid-content-catalogue', compact('Tags'));
    }
}
