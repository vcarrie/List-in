<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function CGU(){
        return view('cgu');
    }

    public function mentionsLegales(){
        return view('mentions-legales');
    }

    public function apropos(){
        return view('apropos');
    }

    public function sitemap(){
        return view('sitemap');
    }


}
