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

namespace App\Repositories\GuestWishlists;

use Illuminate\Http\Request;
use App\MelaMart\Entities\GuestWishlist;
use Illuminate\Support\Facades\Cookie;

/**
 * GuestWishlist Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class GuestWishlistRepository implements GuestWishlistRepositoryInterface
{
    /**
     * -------------------------------------------------
     * Index
     * -------------------------------------------------
     * 1. userProductExists($userId, $product_id);
     * 2. userExists($userId);
     * 3. saveWishlist($userId, Request $request);
     * 4. deleteWishlist(Request $request);
     * 5. get($userId);
     * -------------------------------------------------
     */

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
        return GuestWishlist::where(
            [
                ['product_id', $product_id], ['user_id', $userId]
            ]
        )
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
        return GuestWishlist::where('user_id', $userId)->exists();
    }
    /**
     * Adds item to wishlist
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function saveWishlist(Request $request)
    {
        $userId = Cookie::get('melamart_session');
        $productId = $request->product_id;
        //if user guest user has already added to cart
        if ($this->userExists($userId)) {
            //if guest user has already added product to cart
            if ($this->userProductExists($userId, $productId)) {
                $response = false;
                return $response;
            } else {
                $addtocart = new GuestWishlist();
                $addtocart->user_id = $userId;
                $addtocart->product_id = $request->product_id;
                $addtocart->save();

                $response = true;
                return $response;
            }
        } else {
            $addtocart = new GuestWishlist();
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
     * @param int $productId  
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteWishlist($productId)
    {
        $userId = Cookie::get('melamart_session');
        GuestWishlist::where(
            [
                ['user_id', $userId], ['product_id', $productId]
            ]
        )
            ->delete();
    }
    /**
     * Gets guest user wishlist     
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($userId)
    {
        return GuestWishlist::where('user_id', $userId)->get();
    }
}
