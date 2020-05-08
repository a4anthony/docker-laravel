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

namespace App\MelaMart\Entities;

use App\MelaMart\Entities\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Order Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class Order extends Model
{
    /**
     * Gets product in order
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    /**
     * Gets all products in order
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function products($order)
    {
        $order = Order::where('reference',  $order->reference)->get();

        foreach ($order as $order) {
            $query[] =  Product::find($order->product_id);
        }
        return $query;
    }
    /**
     * Gets customer invoive total
     *
     * @param query $query 
     * @param int   $userId 
     * @param array $total 
     *
     * @return int
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function scopetotal($query, $order)
    {
        $total = [];
        $arrayOrder = $this->where('reference', $order->reference)
            ->get();
        foreach ($arrayOrder as $order) {
            $total[] = $order->quantity * $order->price;
        }
        return array_sum($total);
    }
    public function quantity($order, $product)
    {
        return $this->where(
            [
                ['reference', $order->reference], ['product_id', $product->id]
            ]
        )->pluck('quantity')->first();
    }
    public function price($order, $product)
    {
        $order = $this->where(
            [
                ['reference', $order->reference], ['product_id', $product->id]
            ]
        )->first();
        $total = $order->quantity * $order->price;

        return $total;
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function totalOrders($user)
    {
        return Order::whereNotNull('reference')
            ->where('user_id', $user->id)
            ->get()
            ->groupBy('reference')
            ->count();
    }
    public function allTimeTotal($user)
    {
        $total = [];
        $arrayOrder = $this->where('user_id', $user->id)
            ->get();
        foreach ($arrayOrder as $order) {
            $total[] = $order->quantity * $order->price;
        }
        return array_sum($total);
    }
}
