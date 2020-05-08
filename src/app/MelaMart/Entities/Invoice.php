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

use Illuminate\Database\Eloquent\Model;
use App\MelaMart\Entities\Product;

/**
 * Invoice Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class Invoice extends Model
{
    /**
     * Gets product in generated invoice
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
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
    public function scopetotal($query, $userId, $total = [])
    {
        $arrayInvoice = $this->where([['user_id', $userId], ['status', 'unpaid']])
            ->get();
        foreach ($arrayInvoice as $invoice) {
            $total[] = $invoice->quantity * $invoice->price;
        }
        return array_sum($total);
    }
    /**
     * Gets invoice array to check if user has made changes to cart
     *
     * @param query $query 
     * @param int   $userId 
     * @param array $total 
     *
     * @return array
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function scopecheck($query, $userId, $total = [])
    {
        $productId = [];
        $quantity = [];
        $arrayInvoice = $this->where([['user_id', $userId], ['status', 'unpaid']])
            ->get();
        foreach ($arrayInvoice as $invoice) {
            $productId[] = (int) $invoice->product_id;
            $quantity[] =  (int) $invoice->quantity;
        }
        if ($productId == null) {
            $total = [];
            return $total;
        } else {
            $total = ['productId' => $productId, 'quantity' => $quantity];
            return $total;
        }
    }
}
