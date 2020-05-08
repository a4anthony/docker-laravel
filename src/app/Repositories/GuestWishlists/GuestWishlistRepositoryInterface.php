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

/**
 * GuestWishlist Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface GuestWishlistRepositoryInterface
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
    public function userProductExists($userId, $product_id);
    /**
     * Check user entry in database
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userExists($userId);
    /**
     * Adds item to wishlist
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function saveWishlist(Request $request);
    /**
     * Deletes item from wishlist
     *
     * @param int $productId  
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteWishlist($productId);
    /**
     * Gets guest user wishlist     
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($userId);
}
