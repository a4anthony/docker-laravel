<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::group(['middleware' => 'guest'], function () {
    Route::post('login', 'Api\Controllers\LoginController@login');
    Route::post('register', 'Api\Controllers\AuthController@register');
});


Route::get('users', 'Api\Controllers\UsersController@index');
Route::get('users/{user}', 'Api\Controllers\UsersController@show');
Route::post('users', 'Api\Controllers\UsersController@store');
Route::put('users/{user}', 'Api\Controllers\UsersController@update');
Route::delete('users/{user}', 'Api\Controllers\UsersController@destroy');


Route::get('products', 'Api\Controllers\ProductsController@index');
Route::get('products/{product}', 'Api\Controllers\ProductsController@show');
Route::post('products', 'Api\Controllers\ProductsController@store');
Route::put('products/{product}', 'Api\Controllers\ProductsController@update');
Route::delete('products/{product}', 'Api\Controllers\ProductsController@destroy');

Route::get('categories', 'Api\Controllers\CategoriesController@index');
Route::get('category/{categoryId}', 'Api\Controllers\CategoriesController@show');


/////////////////////////////////////////////////////
///////////// ROUTES FOR CARTCONTROLLER /////////////
/////////////////////////////////////////////////////

//index
Route::get('cart/{userId}', 'Api\Controllers\CartController@index');
//update
Route::put('/cart/update/{userId}/{productId}/{quantity}', 'Api\Controllers\CartController@update');
//destroy
Route::delete('/cart/delete/{userId}/{productId}', 'Api\Controllers\CartController@destroy');
//store
Route::post('cart', 'Api\Controllers\CartController@store');






/////////////////////////////////////////////////////
///////////// ROUTES FOR SEARCHCONTROLLER ///////////
/////////////////////////////////////////////////////

Route::get('/items/search', 'Api\Controllers\SearchController@getsearch');
Route::get('/price', 'Api\Controllers\SearchController@getPrice');
Route::post('search', 'Api\Controllers\SearchController@index');
Route::post('/autocomplete', 'Api\Controllers\SearchController@search');
Route::get('/subcategory/{subCategoryId}', 'Api\Controllers\SearchController@getSubCategory');


/////////////////////////////////////////////////////
/////////// ROUTES FOR WISHLISTCONTROLLER ///////////
/////////////////////////////////////////////////////

//show
Route::get('/wishlist/{userId}', 'Api\Controllers\WishlistController@index');

//destroy
Route::delete('/wishlist/{userId}/{productId}', 'Api\Controllers\WishlistController@destroy');

//store
Route::post('/wishlist', 'Api\Controllers\WishlistController@store')
    ->name('add_to_wishlist');