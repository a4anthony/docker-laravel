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
use App\MelaMart\Entities\Product;

/**
 * Home Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class HomeController extends Controller
{
    /**
     * Handles all get requests to this controller
     *
     * @param \Illuminate\Http\Request       $request 
     * @param \App\MelaMart\Entities\Product $product 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request, Product $product)
    {
        if ($request->path() == "/") {
            return view('store.home', ['productImages' => $product->images]);
        }
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        return view('store.' . $url, ['productImages' => $product->images]);
    }
}
