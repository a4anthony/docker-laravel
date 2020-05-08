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

use Illuminate\Http\Request;

/**
 * Wishlist Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface WishlistRepositoryInterface
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
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function saveWishlist(Request $request);
    /**
     * Deletes item from wishlist
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteWishlist(Request $request);
    /**
     * Gets wishlist items by user 
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($userId);
}
