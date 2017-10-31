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


// Official routes

Route::get('/', function () {
    return view('catalogue');
});

Route::get('/catalogue', function () {
    return view('catalogue');
});

Route::get('/list/{id}', 'ListController@show');

Route::get('/json/list/{id}', 'ListController@getJson');