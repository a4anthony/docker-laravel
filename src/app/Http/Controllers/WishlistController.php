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
use App\Repositories\Wishlists\WishlistRepositoryInterface;
use App\Repositories\GuestWishlists\GuestWishlistRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;

/**
 * Wishlist Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class WishlistController extends Controller
{
    protected $wishlist, $guestwishlist, $product;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Wishlists\WishlistRepositoryInterface           $wishlist 
     * @param \App\Repositories\GuestWishlists\GuestWishlistRepositoryInterface $guestwishlist 
     * @param \App\Repositories\Products\ProductRepositoryInterface             $product 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(WishlistRepositoryInterface $wishlist, GuestWishlistRepositoryInterface $guestwishlist, ProductRepositoryInterface $product)
    {
        $this->product = $product;
        $this->wishlist = $wishlist;
        $this->guestwishlist = $guestwishlist;
    }
    /**
     * Adds item to wishlist
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $model = $this->wishlist;
        } else {
            $model = $this->guestwishlist;
        }
        $response =  $model->saveWishlist($request);
        return $this->returnResponse($request, $response);
    }
    /**
     * Deletes item from wishlist
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function destroy(Request $request)
    {
        $this->wishlist->deleteWishlist($request);
        return redirect()->route('wishlist')->with('success', 'Wishlist Updated.');
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
     * Return response on adding to wishlist
     *
     * @param \Illuminate\Http\Request $request 
     * @param bool                     $response  
     * 
     * @return Illuminate\Http\Response
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function returnResponse(Request $request, $response)
    {
        if ($response == false) {
            $product = $this->product->get($request->product_id);
            return response()->json(
                [
                    'msg' => 'Already in wishlist',
                    'title' => $product->title
                ]
            );
            return redirect()->route('cart')->with('success', 'Already in wishlist');
        } else {
            $product = $this->product->get($request->product_id);
            return response()->json(
                [
                    'msg' => 'Added to wishlist successfully',
                    'title' => $product->title
                ]
            );
        }
    }
}
