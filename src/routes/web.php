<?php

use App\MelaMart\Entities\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get(
    '/home',
    function () {
        return redirect()->route('home');
    }
);


/////////////////////////////////////////////////////
////////// ROUTES FOR HOMECONTROLLER ////////////////
/////////////////////////////////////////////////////

//index
Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@index');
Route::get('/policy/delivery', 'HomeController@index');
Route::get('/policy/return', 'HomeController@index');
Route::get('/terms&conditions', 'HomeController@index');
Route::post('/subscribe', 'SubscriberController@newSubscriber');
Route::get('/contact', 'HomeController@index');
Route::post('/contactsubmit', 'HomeController@contactSubmit');



/////////////////////////////////////////////////////
////////// ROUTES FOR MESSAGESCONTROLLER ////////////////
/////////////////////////////////////////////////////

//index
Route::post('/contact', 'MessagesController@send');



/////////////////////////////////////////////////////
//////// ROUTES FOR SUBSCRIBERCONTROLLER ////////////
/////////////////////////////////////////////////////

Route::post('/subscribe', 'SubscriberController@store');




/////////////////////////////////////////////////////
////////// ROUTES FOR PROFILECONTROLLER /////////////
/////////////////////////////////////////////////////

//index
Route::get('/account', 'ProfileController@index')->name('profile');
Route::get('/account/orders', 'ProfileController@index')->name('orders');
Route::get('/account/wishlist', 'ProfileController@index')->name('wishlist');
Route::get('/account/address-book', 'ProfileController@index')->name('address');
//create
Route::get('/account/orders/feedback/{productId}', 'ProfileController@create');
Route::get('/account/address-book/add', 'ProfileController@create');
//store
Route::post('/feedback/submit', 'ProfileController@store');
Route::post('/account/add/address', 'ProfileController@store');
//edit
Route::get('/account/edit/details', 'ProfileController@edit');
Route::get('/account/address-book/edit/{address_id}', 'ProfileController@edit');
Route::get('/account/update/password', 'ProfileController@edit');
//update
Route::put('/edit/details', 'ProfileController@update');
Route::put('/account/edit/address', 'ProfileController@update');
Route::put('/checkout/edit/address', 'ProfileController@update');
Route::put('/update/password', 'ProfileController@update');
//destroy
Route::delete('/account/address-book/delete', 'ProfileController@destroy');



/////////////////////////////////////////////////////
///////////// ROUTES FOR CARTCONTROLLER /////////////
/////////////////////////////////////////////////////

//index
Route::get('/cart', 'CartController@index')->name('cart');
//update
Route::put('/cart/update/{product_id}/{quantity}', 'CartController@update');
//destroy
Route::delete('/cart/delete/{product_id}', 'CartController@destroy');
//store
Route::post('/item/add-to-cart', 'CartController@store')->name('add_to_cart');



/////////////////////////////////////////////////////
/////////// ROUTES FOR INVOICECONTROLLER ////////////
/////////////////////////////////////////////////////

//store
Route::post('/invoice', 'InvoiceController@store');
//index
Route::get('/checkout', 'InvoiceController@index')->name('invoice');
//show
Route::get('/checkout/address/{address_id}', 'InvoiceController@show');


/////////////////////////////////////////////////////
/////////// ROUTES FOR WISHLISTCONTROLLER ///////////
/////////////////////////////////////////////////////

//destroy
Route::delete('/wishlist/delete/{product_id}', 'WishlistController@destroy');

//store
Route::post('/item/add-to-wishlist', 'WishlistController@store')
    ->name('add_to_wishlist');



/////////////////////////////////////////////////////
/////////// ROUTES FOR PASSWORDCONTROLLER ///////////
/////////////////////////////////////////////////////

//index
Route::get('/reset/password', 'PasswordController@index');
//update
Route::post('/reset/password/{token}', 'PasswordController@update');
//edit
Route::get('/reset/password/{token}', 'PasswordController@edit');
//send mail
Route::post('/reset/password', 'PasswordController@mail');




/////////////////////////////////////////////////////
///////////// ROUTES FOR SEARCHCONTROLLER ///////////
/////////////////////////////////////////////////////

Route::get('/items/search', 'SearchController@getsearch');
Route::get('/price', 'SearchController@getPrice');
Route::post('search', 'SearchController@index');
Route::post('/autocomplete', 'SearchController@search');
Route::get('/subcategory/{subCategoryId}', 'SearchController@getSubCategory');




/////////////////////////////////////////////////////
//////////// ROUTES FOR PAYMENTCONTROLLER ///////////
/////////////////////////////////////////////////////

Route::post('/pay', 'PaymentController@initialize');
Route::post('/webhook', 'PaymentController@webhook');
Route::get('/paymentverification', 'PaymentController@verify');




/////////////////////////////////////////////////////
/////// ROUTES FOR EMAILVERIFICATIONCONTROLLER //////
/////////////////////////////////////////////////////

Route::get('verifyemail', 'EmailVerificationController@sendVerificationEmail');
Route::get('verifyemail/{token}', 'EmailVerificationController@verifyEmail');




/////////////////////////////////////////////////////
//////////// ROUTES FOR PRODUCTSCONTROLLER //////////
/////////////////////////////////////////////////////

Route::get('/item/{slug}', 'ProductsController@show')->name('item');





/////////////////////////////////////////////////////
//////////////////// TEST ROUTES ////////////////////
/////////////////////////////////////////////////////

Route::get('/email', 'EmailTestController@send'); //for email testing with mailgun



Route::get(
    '/test-mail',
    function () {
        return view(
            'store.emails.verifyemail',
            [
                'customer_firstname' =>     'Tony',
                'customer_lastname' => 'Akro',
                'customer_email' => 'anthonygakro@gmail.com',
                'customer_token' => 'dnfbnfjkhjkgdhjgfjfhjhjhjkhjgfh',
            ]
        );
    }
);
Route::get(
    '/test-mail-1',
    function () {
        return view(
            'store.emails.passwordreset',
            [
                'customer_firstname' => 'tony',
                'reset_link' => 'sdjbhbkrhebhvrbreherjb',
            ]
        );
    }
);
Route::get(
    '/test-products',
    function () {
        return view(
            'store.test-products',
            [
                'arrayProducts' => Product::latest()->get(),
            ]
        );
    }
);


 Route::get('/phpinfo', function() {
     return phpinfo();
 });