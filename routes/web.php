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

Route::get('/admin',  ['middleware' => ['auth', 'admin'], 'uses' => 'AdminController@panelAdmin']);
Route::get('/manage/tag',  ['middleware' => ['auth', 'admin'], 'uses' => 'TagsController@manageTags']);
Route::post('/delete/tag',  ['middleware' => ['auth', 'admin'], 'uses' => 'TagsController@deleteTags']);
Route::post('/create/tag',  ['middleware' => ['auth', 'admin'], 'uses' => 'TagsController@createTags']);

Route::get('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@get');
Route::post('/getproductbykeyword', 'ApiCdiscountSearchByKeywordController@post');

Route::get('/removefromcart/{id}', 'CartController@RemoveListFromCart');
Route::get('/addtocart/{id}', 'CartController@addListToCart');
Route::get('/emptycart', 'CartController@empty_cart');
Route::get('/cart', 'CartController@show_cart')->name('cart');
Route::get('/getcart', 'CartController@get_cart');


Route::get('/', 'HomeController@index');

Route::get('/research', 'HomeController@research');

Route::get('/catalogue', 'HomeController@index');

Route::get('/catalogue-struct', 'HomeController@struct');

Route::get('/tags', 'TagsController@getTags');
Route::get('/tagsnotempty', 'TagsController@getTagsNotEmpty');


Route::get('/contact', 'ContactController@create');
Route::post('/contact', 'ContactController@store');

Route::get('/user/{id}', 'UserController@show');
Route::get('/account', 'UserController@myAccount');
Route::get('/account/emailSuccess', 'ChangeEmailController@successChangeEmail');


Route::get('/cgu', 'FooterController@CGU');
Route::get('/mentionslegales', 'FooterController@mentionsLegales');

Route::get('/apropos', 'FooterController@apropos');

Route::get('/registercomment', 'CommentController@registerComment');
Route::get('/registerrate', 'CommentController@registerRate');




// Email confirmation
Route::get('/confirmation/resend', 'Auth\RegisterController@resend');
Route::get('/confirmation/{id}/{token}', 'VerifyEmailController@index');



//Delete
Route::delete('/delete/rate/{id}',  ['middleware' => ['auth', 'admin'], 'uses' => 'DeleteController@deleteRate']);
Route::delete('/delete/categorize/{id}',  ['middleware' => ['auth', 'admin'], 'uses' => 'DeleteController@deleteCategorize']);
Route::delete('/delete/comment/{id}',  ['middleware' => ['auth', 'admin'], 'uses' => 'DeleteController@deleteComment']);
Route::delete('/delete/belong/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'DeleteController@deleteBelong']);
Route::get('/delete/list/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'ListController@deleteList']);
Route::get('/delete/userlist/{id}', 'ListController@deleteUserList');

Route::get('/delete/user/{id}', ['middleware' => ['auth', 'admin'], 'uses' => 'UserController@deleteUser']);

//Update
Route::post('/update/user/password', 'UserController@updateUserPassword');
Route::post('/update/user/email', 'UserController@updateUserEmail');