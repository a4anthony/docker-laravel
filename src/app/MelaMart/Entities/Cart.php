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
 * Cart Model Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class Cart extends Model
{
    /**
     * Retieves cart item
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    /**
     * Cart items array to monitor changes with 
     * generated invoice
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
        $arrayCart = $this->where('user_id', $userId)->get();
        $productId = [];
        $quantity = [];
        foreach ($arrayCart as $cart) {
            $product = $cart->product;
            if ($product->quantity != 0) {
                $productId[] =  (int) $product->id;
                $quantity[] =  (int) $cart->quantity;
            }
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
