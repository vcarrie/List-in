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
    return view('layouts.base');
});
Route::get('/liste', function () {
    return view('list');
});


// Official routes

Route::get('/', function () {
    return view('catalogue');
});

Route::get('/catalogue', function () {
    return view('catalogue');
});

Route::get('/liste/{id}', 'ListController@show');

Route::get('/auth', function() {
    return view('auth');
});

Route::get('/a-propos', function () {
    return view('about');
});

Route::get('/mentions-legales', function () {
    return view('legal');
});

Route::get('/cgu', function () {
    return view('cgu');
});

Route::get('/sitemap', function () {
    return view('sitemap');
});

Route::get('/contact', function () {
    return view('contact');
});

// Services

Route::get('/liste/{id}/json', 'ListController@getList');

Route::get('/tags', 'TagsController@getTags');
