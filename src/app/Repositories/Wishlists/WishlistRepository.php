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

namespace App\Repositories\Wishlists;

use Illuminate\Support\Facades\Auth;
use App\MelaMart\Entities\Wishlist;
use Illuminate\Http\Request;

/**
 * Wishlist Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class WishlistRepository implements WishlistRepositoryInterface
{
    /**
     * Checks if user-products entry already exists
     *
     * @param int $userId 
     * @param int $product_id 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userProductExists($userId, $product_id)
    {
        return Wishlist::where([['product_id', $product_id], ['user_id', $userId]])
            ->exists();
    }
    /**
     * Check user entry in database
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userExists($userId)
    {
        return Wishlist::where('user_id', $userId)->exists();
    }
    /**
     * Adds item to wishlist
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function saveWishlist(Request $request)
    {
        $userId = Auth::id(); //gets user id
        //if api call
        if ($request->getHttpHost() == env('API_URL')) {
            $userId = (int) $request->user_id;
        }
        $productId = $request->product_id;
        //if user guest user has already added to cart
        if ($this->userExists($userId)) {
            //if guest user has already added product to cart
            if ($this->userProductExists($userId, $productId)) {
                $response = false;
                return $response;
            } else {
                $addtocart = new Wishlist();
                $addtocart->user_id = $userId;
                $addtocart->product_id = $request->product_id;
                $addtocart->save();

                $response = true;
                return $response;
            }
        } else {
            $addtocart = new Wishlist();
            $addtocart->user_id = $userId;
            $addtocart->product_id = $request->product_id;
            $addtocart->save();

            $response = true;
            return $response;
        }
    }
    /**
     * Deletes item from wishlist
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteWishlist(Request $request)
    {
        $userId = Auth::id(); //gets current user id
        //if api call
        if ($request->getHttpHost() == env('API_URL')) {
            $userId = (int) $request->user_id;
        }

        Wishlist::where(
            [
                ['user_id', $userId], ['product_id', $request->product_id]
            ]
        )->delete();
    }
    /**
     * Gets wishlist items by user 
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($userId)
    {
        return Wishlist::where('user_id', $userId)->get();
    }
}
