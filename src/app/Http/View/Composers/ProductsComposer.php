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

namespace App\Http\View\Composers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Carts\CartRepositoryInterface;
use App\Repositories\Categories\CategoryRepositoryInterface;
use App\Repositories\GuestCarts\GuestCartRepositoryInterface;


/**
 * Composer Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class  ProductsComposer
{
    protected $product;
    protected $cart;
    protected $category;
    protected $guestcart;
    /**
     * Composer cONSTRUCT
     *
     * @param \App\Repositories\Products\ProductRepositoryInterface     $product 
     * @param \App\Repositories\Carts\CartRepositoryInterface           $cart 
     * @param \App\Repositories\Categories\CategoryRepositoryInterface  $category 
     * @param \App\Repositories\GuestCarts\GuestCartRepositoryInterface $guestcart 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(
        ProductRepositoryInterface $product,
        CartRepositoryInterface $cart,
        CategoryRepositoryInterface $category,
        GuestCartRepositoryInterface $guestcart
    ) {
        $this->product = $product;
        $this->cart = $cart;
        $this->category = $category;
        $this->guestcart = $guestcart;
    }
    /**
     * Returns to all store views
     *
     * @param \Illuminate\View\View $view 
     *
     * @return \Illuminate\View\View 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function compose(View $view)
    {
        //checks if user is logged in
        if (Auth::check()) {
            $model = $this->cart;
        } else {
            $model = $this->guestcart;
        }
        $count_cart_items = $model->countCart();
        $featured_products = $this->product->featured();
        $new_arrivals_products = $this->product->newArrivals();
        $best_deals_products = $this->product->bestDeals();
        $allCategories = $this->category->allCategory();

        $view->with(
            [
                'array_featured_products' => $featured_products,
                'array_new_arrivals_products' => $new_arrivals_products,
                'array_best_deals_products' => $best_deals_products,
                'count_cart_items' => $count_cart_items,
                'allCategories' => $allCategories,
            ]
        );
    }
}
