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

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Carts\CartRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\GuestCarts\GuestCartRepositoryInterface;

/**
 * Cart Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class CartController extends Controller
{
    protected $product, $cart, $guestcart;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Products\ProductRepositoryInterface     $product 
     * @param \App\Repositories\Carts\CartRepositoryInterface           $cart 
     * @param \App\Repositories\GuestCarts\GuestCartRepositoryInterface $guestcart 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com>
     */
    public function __construct(ProductRepositoryInterface $product, CartRepositoryInterface $cart, GuestCartRepositoryInterface $guestcart)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->guestcart = $guestcart;
        $this->middleware('auth')->except('store');
    }
    /**
     * Handles cart index request
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request)
    {
        $allCartItems = [];
        $arrayProductsInStock = [];
        $arrayProductsNoStock = [];
        $productId = [];

        $model = $this->checkAuth();

        $allCartItems = $model->getCartItems($request);

        foreach ($allCartItems as $cart) {
            $product = $cart->product;
            if ($product->quantity != 0) {
                $arrayProductsInStock[] = $product;
                $productId[] = $product->id;
            } else {
                $arrayProductsNoStock[] = $product;
            }
        }

        return view(
            'store.cart',
            [
                'allCartItems' => $allCartItems,
                'arrayProductsInStock' => $arrayProductsInStock,
                'arrayProductsNoStock' => $arrayProductsNoStock,
                'productId' => $productId,
            ]
        );
    }
    /**
     * Adds item to cart
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        $model = $this->checkAuth();

        $response =  $model->save($request);
        return $this->redirectRouteStore($request, $response, $model);
    }
    /**
     * Updates cart item quantity
     *
     * @param int $productId 
     * @param int $quantity 
     *
     * @return Illuminate\Http\Response 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update($productId, $quantity)
    {
        $model = $this->checkAuth();
        $request = new Request();
        $model->updateQuantity($request, $productId, $quantity);
        $request = new Request();
        $allCartItems = $model->getCartItems($request);
        return  $this->redirectRoute($allCartItems, $productId, $quantity);
    }
    /**
     * Deletes from cart
     *
     * @param \Illuminate\Http\Request $request 
     * @param int                      $productId 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function destroy(Request $request, $productId)
    {
        $model = $this->checkAuth();

        $model->deleteCart($request, $productId);
        return redirect()->route('cart')->with('success', 'Cart Updated.');
    }


    /**
     * -----------------------------------------------------------------------------------------
     * Controller Methods (BELOW)
     * -----------------------------------------------------------------------------------------
     * Here is where you can register methods for this controller. 
     * The methods here will be used to avoid code repitiotion 
     * and to simplify restful action above
     */


    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request              $request 
     * @param bool                                  $response 
     * @param \App\Repositories\Products\[selector] $model 
     *
     * @return Illuminate\Http\Response 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function redirectRouteStore(Request $request, $response, $model)
    {
        if ($response == false) {
            if ($request->ajax()) {
                $product = $this->product->get($request->product_id);
                return response()->json(
                    [
                        'msg' => 'Already in cart',
                        'title' => $product->title
                    ]
                );
            }
            return redirect()->route('cart')->with('success', 'Already in cart');
        } else {
            if ($request->ajax()) {
                $count_cartItems = $model->countCart();
                $product = $this->product->get($request->product_id);

                return response()->json(
                    [
                        'msg' => 'Added to cart successfully',
                        'count_cartItems' => $count_cartItems,
                        'title' => $product->title
                    ]
                );
            }
            return redirect()->route('cart')->with('success', 'Added to cart successfully');
        }
    }
    /**
     * Redirects to route after update
     *
     * @param array $allCartItems  
     * @param int   $productId 
     * @param int   $quantity 
     *
     * @return Illuminate\Http\Response 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function redirectRoute($allCartItems, $productId, $quantity)
    {
        //check if items in cart have gotten out of cart
        foreach ($allCartItems as $cart) {
            $product = $cart->product;
            if ($product->id == $productId) {
                if ($product->quantity != 0) {
                    $total = $quantity * $product->total_price;
                    $initiallTotal = $quantity * $product->initial_price;
                }
            }
            if ($product->quantity != 0) {
                $arrayCartTotal[] = $cart->quantity * $product->total_price;
            }
        }

        $cartTotal = array_sum($arrayCartTotal);
        return response()->json(
            [
                'total' => number_format($total),
                'initialTotal' => number_format($initiallTotal),
                'cartTotal' => number_format($cartTotal)
            ]
        );
    }
    /**
     * Assign model bu user auth() status
     *
     * @return $model
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function checkAuth()
    {
        if (Auth::check()) {
            $model = $this->cart;
        } else {
            $model = $this->guestcart;
        }
        return $model;
    }
}
