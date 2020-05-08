<?php

namespace App\Http\Controllers\Auth;

use App\MelaMart\Entities\GuestCookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Carts\CartRepositoryInterface;
use App\Repositories\Categories\CategoryRepositoryInterface;
use App\Repositories\GuestCarts\GuestCartRepositoryInterface;
use App\Repositories\GuestWishlists\GuestWishlistRepositoryInterface;
use App\Repositories\Wishlists\WishlistRepositoryInterface;
use App\Repositories\GuestCookies\GuestCookieRepositoryInterface;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductRepositoryInterface $product,
        CartRepositoryInterface $cart,
        CategoryRepositoryInterface $category,
        GuestCartRepositoryInterface $guestcart,
        GuestCookieRepositoryInterface $guestcookie,
        GuestWishlistRepositoryInterface $guestwishlist,
        WishlistRepositoryInterface $wishlist
    ) {
        $this->product = $product;
        $this->cart = $cart;
        $this->category = $category;
        $this->guestcart = $guestcart;
        $this->guestcookie = $guestcookie;
        $this->guestwishlist = $guestwishlist;
        $this->wishlist = $wishlist;
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        //stores cookies of user before login
        if (GuestCookie::where('email', request('email'))->exists()) {
            GuestCookie::where('email', request('email'))->update(['cookie' => $request->cookie('melamart_session')]);
        } else {
            $save_guest_cookie = new GuestCookie();
            $save_guest_cookie->email = request('email');
            $save_guest_cookie->cookie = $request->cookie('melamart_session');
            $save_guest_cookie->save();
        }


        ////  LEAVE BELOW THIS ALONE  //////////////////

        ////   BELOW MAY NOT EVEN BE NEEDED TO WORK  TRY WITHOUT FIRST

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->update();
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Updates cart and wishlist after login
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update()
    {
        //MOVING CART ITEM IF USER LOGIN OR CREATE ACCOUNT
        $email = Auth::user()->email; //gets user email
        $userId = GuestCookie::where('email', $email)->pluck('cookie')->first();
        //if cookie exists 
        if ($userId != null) {
            $request = new Request();
            $get_guest_cart_items = $this->guestcart->getCartItems($request);
            $get_guest_wishlist = $this->guestwishlist->get($userId);
            //dd($get_guest_cart_items);
            foreach ($get_guest_cart_items as $cart_item) {
                $productId = $cart_item->product_id;
                //if it is not users first cart item
                if ($this->cart->userExists($userId)) {
                    //if user has already added item to cart => 
                    if ($this->cart->userProductExists($userId, $productId)) {
                        //do nothing
                    } else {
                        $this->cartRequest($userId, $cart_item);
                    }
                } else {
                    $this->cartRequest($userId, $cart_item);
                }
                $this->guestcart->deleteCart($productId);
            }

            foreach ($get_guest_wishlist as $savedItem) {
                $productId = $savedItem->product_id;
                //if it is not users first cart item
                if ($this->wishlist->userExists($userId)) {
                    //if user has already added item to cart => 
                    if ($this->wishlist->userProductExists($userId, $productId)) {
                        //do nothing
                    } else {
                        $this->wishlistRequest($savedItem);
                    }
                } else {
                    $this->wishlistRequest($savedItem);
                }
                $this->guestwishlist->deleteWishlist($productId);
            }
        }
    }
    /**
     * Moves items from guestcart to cart
     *
     * @param int   $userId 
     * @param array $cart_item 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function cartRequest($userId, $cart_item)
    {
        $request = new Request();
        $request->merge(
            [
                'user_id' => $userId,
                'quantity' => (int) $cart_item->quantity,
                'product_id' => $cart_item->product_id
            ]
        );
        $this->cart->save($request);
    }
    /**
     * Moves items from guestwishlist to wishlist
     *
     * @param array $savedItem 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function wishlistRequest($savedItem)
    {
        $request = new Request();
        $request->merge(
            [
                'product_id' => $savedItem->product_id
            ]
        );
        $this->wishlist->saveWishlist($request);
    }
}
