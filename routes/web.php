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

Route::middleware('auth')->group(function () {
    Route::get('/create/list', 'ListController@createList');
    Route::post('/create/list', 'ListController@validateCreateList');
});


Route::get('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@get');
Route::post('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@post');

Route::get('/removefromcart', 'CartController@RemoveFromCart');
Route::get('/addtocart', 'CartController@addToCart');


Route::get('/', 'HomeController@index');




Route::get('/research', 'HomeController@research');

Route::get('/catalogue', 'HomeController@index');

Route::get('/tags', 'TagsController@getTags');


Route::get('/contact', 'ContactController@create');
Route::post('/contact', 'ContactController@store');

Route::get('/user/{id}', 'UserController@show');
Route::get('/myaccount', 'UserController@myAccount');

Route::get('/cgu', 'FooterController@CGU');
Route::get('/mentionslegales', 'FooterController@mentionsLegales');

// Email confirmation
Route::get('/confirmation/resend', 'Auth\RegisterController@resend');
Route::get('/confirmation/{id}/{token}', 'Auth\RegisterController@confirm');


//Special Route
Route::get('/dunsparce', function(){
    return view('hidden.dunsparce');
});

