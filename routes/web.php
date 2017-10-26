<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Tag;

Route::get('/tag', function () {

    $tag = Tag::find(1);

    return view('welcome', compact("tag"));
});

Route::get('/auth/login', 'Authentication@login');

Route::post('/auth/login', 'Authentication@checkLogin');

Route::get('/auth/register', 'Authentication@register');

Route::get('/marceau', function (){
    return view('layouts.mid-content-catalogue');
});
