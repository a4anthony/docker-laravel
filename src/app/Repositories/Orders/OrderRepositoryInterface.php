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

namespace App\Repositories\Orders;

use Illuminate\Http\Request;

/**
 * Orders Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface OrderRepositoryInterface
{
    /**
     * Gets orders by reference
     *
     * @param string $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function orders($filter);
    /**
     * Updates order status
     *
     * @param \Illuminate\Http\Request $request 
     * @param string                   $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateOrder(Request $request, $filter);
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newOrders();
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function shippedOrders();
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deliveredOrders();
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function returnedOrders();
    /**
     * Gets post by Id
     *
     * @param int $productId 
     *
     * @return mixed
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($productId);
    /**
     * Gets orders by customer email
     *
     * @param int $userId 
     * 
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function customerOrders($userId);
    /**
     * Gets customer transaction and spends
     *
     * @param int $userId 
     * 
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function customerTranscDetails($userId);
    /**
     * Gets order by reference
     *
     * @param string $reference 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getOrder($reference);
    /**
     * Gets order by reference
     *
     * @param string $reference 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */

    /**
     * Ship order 
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function shipOrder($reference);
    /**
     * Deliver order 
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deliverOrder($reference);
    /**
     * Return order 
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function returnOrder($reference);
    /**
     * Gets users orders
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getUserOrders($userId);
    /**
     * Check if order exists
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function orderExists($reference);
    /**
     * Saves new order
     * 
     * @param int    $invoice_id  
     * @param string $trasc_status 
     * @param int    $address_id 
     * @param string $order_status 
     * @param string $reference 
     * @param int    $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function save($invoice_id, $trasc_status, $address_id, $order_status, $reference, $userId);
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countNewOrders();
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countShippedOrders();
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countDeliveredOrders();
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countReturnedOrders();
}
