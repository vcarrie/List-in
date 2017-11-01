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

Route::get('/lists/user/{id}', 'ListController@getListesByIdAccount');
Route::get('/lists', 'ListController@getAllLists');
Route::get('/list/{id}', 'ListController@getListById');


Route::post('/tags', 'tags@getTags');

Route::get('/auth/login', 'Authentication@login');

Route::post('/auth/login', 'Authentication@checkLogin');

Route::get('/auth/register', 'Authentication@register');

Route::get('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@get');
Route::post('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@post');

Route::get('/marceau', function (){
    return view('layouts.base');
});

