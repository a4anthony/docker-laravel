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

use App\MelaMart\Entities\Invoice;
use App\MelaMart\Entities\Order;
use App\MelaMart\Entities\Product;
use Illuminate\Http\Request;

/**
 * Orders Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Gets orders by reference
     *
     * @param string $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function orders($filter)
    {
        $filter = explode('.', $filter);
        return Order::whereNotNull('reference')
            ->where('order_status', $filter[1])
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Updates order status
     *
     * @param \Illuminate\Http\Request $request 
     * @param string                   $filter 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateOrder(Request $request, $filter)
    {
        $filter = explode('.', $filter);
        Order::where('reference', $request->reference)
            ->update(['order_status' => $filter[1]]);
    }
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newOrders()
    {
        return Order::whereNotNull('reference')
            ->where('order_status', 'new')
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function shippedOrders()
    {
        return Order::whereNotNull('reference')
            ->where('order_status', 'shipped')
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deliveredOrders()
    {
        return Order::whereNotNull('reference')
            ->where('order_status', 'delivered')
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Gets all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function returnedOrders()
    {
        return Order::whereNotNull('reference')
            ->where('order_status', 'returned')
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Gets post by Id
     *
     * @param int $productId 
     *
     * @return mixed
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function get($productId)
    {
        return Order::find($productId);
    }
    /**
     * Gets orders by customer email
     *
     * @param int $userId 
     * 
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function customerOrders($userId)
    {
        return Order::whereNotNull('reference')
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Gets customer transaction and spends
     *
     * @param int $userId 
     * 
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function customerTranscDetails($userId)
    {
        $amount =  (int) Order::whereNotNull('reference')
            ->where('user_id', $userId)
            ->sum('price');
        $count =  Order::whereNotNull('reference')
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->groupBy('reference')
            ->count();
        $details = ['amount' => $amount, 'count' => $count];
        return $details;
    }
    /**
     * Gets order by reference
     *
     * @param string $reference 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getOrder($reference)
    {

        return Order::whereNotNull('reference')
            ->where('reference', $reference)
            ->latest()
            ->get()
            ->groupBy('reference');
    }
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
    public function shipOrder($reference)
    {
        Order::where('reference', $reference)->update(['order_status' => 'shipped']);
    }
    /**
     * Deliver order 
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function deliverOrder($reference)
    {
        Order::where('reference', $reference)->update(['order_status' => 'delivered']);
    }
    /**
     * Return order 
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function returnOrder($reference)
    {
        Order::where('reference', $reference)->update(['order_status' => 'returned']);
    }
    /**
     * Gets users orders
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getUserOrders($userId)
    {
        return Order::whereNotNull('reference')
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->groupBy('reference');
    }
    /**
     * Check if order exists
     *
     * @param string $reference 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function orderExists($reference)
    {
        return Order::where('reference', $reference)->exists();
    }
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
    public function save($invoice_id, $trasc_status, $address_id, $order_status, $reference, $userId)
    {
        $orderedItems = Invoice::where('invoice_id', $invoice_id)->get();

        foreach ($orderedItems as $order) {
            $product = $order->product;
            $newOrder = new Order();
            $newOrder->user_id = $userId;
            $newOrder->product_id = $product->id;
            $newOrder->price = $order->price;
            $newOrder->quantity = $order->quantity;
            $newOrder->address = $address_id;
            $newOrder->transc_status = $trasc_status;
            $newOrder->order_status = $order_status;
            $newOrder->reference = $reference;
            $newOrder->save();

            $product = Product::find($product->id);
            Product::where('id', $product->id)
                ->update(['quantity' => $product->quantity - $order->quantity]);
        }
    }
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countNewOrders()
    {
        return count($this->newOrders());
    }
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countShippedOrders()
    {
        return count($this->shippedOrders());
    }
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countDeliveredOrders()
    {
        return count($this->deliveredOrders());
    }
    /**
     * Count all Orders
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countReturnedOrders()
    {
        return count($this->returnedOrders());
    }
}
