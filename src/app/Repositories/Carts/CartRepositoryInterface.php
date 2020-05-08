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

use Illuminate\Http\Request;

/**
 * Cart Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface CartRepositoryInterface
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
     * Gets users cart items
     *     
     * @param \Illuminate\Http\Request $request 
     * 
     * @return void 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCartItems(Request $request);
    /**
     * Gets carts items by user Id and product Id
     *
     * @param int $userId 
     * @param int $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCartItemsByProduct($userId, $productId);
    /**
     * Checks if user has any item in cart
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userExists($userId);
    /**
     * Checks user already added item into cart
     *
     * @param int $userId 
     * @param int $productId 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userProductExists($userId, $productId);
    /**
     * Save item in cart
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function save(Request $request);
    /**
     * Counts users items in cart
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countCart();
    /**
     * Empties users cart after checkout
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function emptyCart($userId);
    /**
     * Deletes item from cart
     * 
     * @param \Illuminate\Http\Request $request 
     * @param int                      $productId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deleteCart(Request $request, $productId);
    /**
     * Gets cart item to update quantity
     *
     * @param int $userId  
     * @param int $productId 
     * 
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getCartItemFoF($userId, $productId);
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
    public function updateQuantity(Request $request, $productId, $quantity);
}
