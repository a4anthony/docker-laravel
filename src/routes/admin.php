<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ADMIN routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your ADMIN!
|
*/


Route::get('/login', 'Admin\Controllers\Auth\LoginController@showLoginForm')->name('login.admin');
Route::post('/loginSubmit', 'Admin\Controllers\Auth\LoginController@login')->name('loginSubmit');
Route::post('/logout', 'Admin\Controllers\Auth\LoginController@logout')->name('logout.admin');
Route::get('/', 'Admin\Controllers\HomeController@index');


Route::group(
    ['middleware' => 'authAdmin'],
    function () {

        Route::get('/dashboard', 'Admin\Controllers\HomeController@show')->name('home.admin');

        /////////////////////////////////////////////////////
        /////////// ROUTES FOR PRODUCTSCONTROLLER ///////////
        /////////////////////////////////////////////////////


        //index
        Route::get('/products/all', 'Admin\Controllers\ProductsController@index')->name('allProducts');
        Route::get('/products/live', 'Admin\Controllers\ProductsController@index');
        Route::get('/products/paused', 'Admin\Controllers\ProductsController@index');
        Route::get('/products/out-of-stock', 'Admin\Controllers\ProductsController@index');

        //create
        Route::get('/product/add', 'Admin\Controllers\ProductsController@create');

        //store
        Route::post('/product/add', 'Admin\Controllers\ProductsController@store');

        //update
        Route::put('/product/edit', 'Admin\Controllers\ProductsController@update');
        Route::put('/product/status', 'Admin\Controllers\ProductsController@update');

        //edit
        Route::get('/product/edit/{productId}', 'Admin\Controllers\ProductsController@edit');

        //show
        Route::get('/product/{productId}', 'Admin\Controllers\ProductsController@show');
        Route::get('/subcategory/{mainCategoryId}', 'Admin\Controllers\ProductsController@getSubCategory');



        /////////////////////////////////////////////////////
        ///////////// ROUTES FOR ORDERSCONTROLLER ///////////
        /////////////////////////////////////////////////////

        //index
        Route::get('/orders/new', 'Admin\Controllers\OrdersController@index')->name('ordersNew');
        Route::get('/orders/shipped', 'Admin\Controllers\OrdersController@index')->name('order.shipped');
        Route::get('/orders/delivered', 'Admin\Controllers\OrdersController@index')->name('order.delivered');
        Route::get('/orders/returned', 'Admin\Controllers\OrdersController@index')->name('order.returned');

        //show
        Route::get('/orders/{userId}', 'Admin\Controllers\OrdersController@userOrders');

        //show
        Route::get('/order/{reference}', 'Admin\Controllers\OrdersController@show');

        //update
        Route::put('/order/shipped', 'Admin\Controllers\OrdersController@update');
        Route::put('/order/delivered', 'Admin\Controllers\OrdersController@update');
        Route::put('/order/returned', 'Admin\Controllers\OrdersController@update');



        /////////////////////////////////////////////////////
        /////////// ROUTES FOR PAYSTACKCONTROLLER ///////////
        /////////////////////////////////////////////////////

        //index
        Route::get('/customers', 'Admin\Controllers\PaystackController@index');
        Route::get('/transactions', 'Admin\Controllers\PaystackController@index');



        /////////////////////////////////////////////////////
        /////////// ROUTES FOR MESAAGESCONTROLLER ///////////
        /////////////////////////////////////////////////////

        //index
        Route::get('/messages/all', 'Admin\Controllers\MessagesController@index')->name('allMsg');
        Route::get('/messages/read', 'Admin\Controllers\MessagesController@index');
        Route::get('/messages/unread', 'Admin\Controllers\MessagesController@index')->name('unread');

        //update
        Route::put('/message/unread', 'Admin\Controllers\MessagesController@update');

        //destroy
        Route::delete('/message/delete', 'Admin\Controllers\MessagesController@destroy');

        //show
        Route::get('/message/{messageId}', 'Admin\Controllers\MessagesController@show');


        /////////////////////////////////////////////////////
        ////////// ROUTES FOR CATEGORIESCONTROLLER //////////
        /////////////////////////////////////////////////////

        //index
        //Route::get('/categories/all', 'Admin\Controllers\CategoriesController@index');
        //Route::get('/transactions', 'Admin\Controllers\PaystackController@index');
    }
);
