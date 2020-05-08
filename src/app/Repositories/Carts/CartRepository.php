<?php

/**
 * PHP version 7.3
 * 
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  CVS: <1.0>
 * @link     https://melamartonline.com
 */

namespace App\Repositories\Carts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MelaMart\Entities\Cart;

/**
 * Cart Repository class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class CartRepository implements CartRepositoryInterface
{

    /**
     * -------------------------------------------------
     * Index
     * -------------------------------------------------
     * 1. getCartItems();
     * 2. getCartItemsByProduct($userId, $productId);
     * 3. userExists($userId);
     * 4. userProductExists($userId, $productId);
     * 5. save(Request $request);
     * 6. countCart();
     * 7. demptyCart($userId);
     * 8. eleteCart($productId);
     * 9. getCartItemFoF($userId, $productId);
     * 10. updateQuantity($productId, $quantity);
     * -------------------------------------------------
     */

    /**
     * Get user cart items
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCartItems(Request $request)
    {
        $userId = Auth::id();
        //if api call
        if ($request->getHttpHost() == env('API_URL')) {
            $userId = (int) $request->user_id;
        }
        return Cart::where('user_id', $userId)->get();
    }
    /**
     * Gets carts items by user Id and product Id
     *
     * @param int $userId 
     * @param int $productId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCartItemsByProduct($userId, $productId)
    {
        return Cart::where([['user_id', $userId], ['product_id', $productId]])
            ->get();
    }
    /**
     * Checks if user has any item in cart
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userExists($userId)
    {
        return Cart::where('user_id', $userId)->exists();
    }
    /**
     * Checks user already added item into cart
     *
     * @param int $userId 
     * @param int $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userProductExists($userId, $productId)
    {
        return Cart::where([['product_id', $productId], ['user_id', $userId]])
            ->exists();
    }
    /**
     * Save item in cart
     *
     * @param \Illuminate\Http\Request $request  
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function save(Request $request)
    {
        $userId = Auth::id(); //gets current user id
        //if api call
        if ($request->getHttpHost() == env('API_URL')) {
            $userId = (int) request('user_id');
        }
        $product_id = request('product_id');
        //if guest user has already added an item to cart
        if ($this->userExists($userId)) {
            //if geust user has already added item to cart
            if ($this->userProductExists($userId, $product_id)) {
                $response = false;
                return $response;
            } else {
                $addtocart = new Cart();
                $addtocart->user_id = $userId;
                $addtocart->product_id = $request->product_id;
                $addtocart->quantity = 1;
                $addtocart->save();
                $response = true;
                return $response;
            }
        } else {
            $addtocart = new Cart();
            $addtocart->user_id = $userId;
            $addtocart->product_id = $request->product_id;
            $addtocart->quantity = 1;
            $addtocart->save();

            $response = true;
            return $response;
        }
    }
    /**
     * Counts users items in cart
     *
     * @return int
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countCart()
    {
        $userId = Auth::id();
        return Cart::where('user_id', $userId)->count();
    }
    /**
     * Empties users cart after checkout
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function emptyCart($userId)
    {
        Cart::where('user_id', $userId)->delete();
    }
    /**
     * Deletes item from cart
     *
     * @param int $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteCart(Request $request, $productId)
    {
        $userId = Auth::id();
        //if api call
        if ($request->getHttpHost() == env('API_URL')) {
            $userId = (int) $request->user_id;
        }
        Cart::where([['user_id', $userId], ['product_id', $productId]])->delete();
    }
    /**
     * Gets cart item to update quantity
     *
     * @param int $userId 
     * @param int $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCartItemFoF($userId, $productId)
    {
        return Cart::where([['product_id', $productId], ['user_id', $userId]])
            ->firstOrFail();
    }
    /**
     * Updates carts item quantity
     *
     * @param \Illuminate\Http\Request $request 
     * @param int                      $productId 
     * @param int                      $quantity 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateQuantity(Request $request, $productId, $quantity)
    {
        $userId = Auth::id();
        //if api call
        if ($request->getHttpHost() == env('API_URL')) {
            $userId = (int) $request->user_id;
        }
        Cart::where([['product_id', $productId], ['user_id', $userId]])
            ->update(['quantity' => $quantity]);
    }
}
