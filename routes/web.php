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

Auth::routes();

Route::get('/lists/user/{id}', 'ListController@getListsByIdAccount');
Route::get('/lists', 'ListController@getAllLists');
Route::get('/list/{id}', 'ListController@getListById');

Route::middleware('auth')->group(function () { //ou du moins celui crée
    Route::get('/list/create', 'ListController@createList');
    Route::post('/list/create', 'ListController@validateCreateList');
});


Route::get('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@get');
Route::post('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@post');


Route::get('/', 'HomeController@index');

Route::get('/research', 'HomeController@research');

Route::get('/catalogue', 'HomeController@index');

Route::get('/tags', 'TagsController@getTags');


Route::get('/contact', 'ContactController@create');
Route::post('/contact', 'ContactController@store');

