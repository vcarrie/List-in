<?php

namespace App\Http\Controllers;

use App\Categorize;
use Illuminate\Http\Request;
use App\Tag;


class HomeController extends Controller
{
    public function index(){

        $top_5_ids = Categorize::top_5_most_used_tags();



        $Tags_final_tab = Tag::getByIdsTag($top_5_ids);


        //return $Tags_final_tab;
        return view('layouts.mid-content-catalogue', compact('Tags_final_tab'));
    }
}
