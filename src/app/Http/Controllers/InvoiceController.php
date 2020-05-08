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

use App\MelaMart\Entities\Address;
use App\MelaMart\Entities\Cart;
use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\Invoice;
use App\MelaMart\Entities\Product;
use App\MelaMart\Entities\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Carts\CartRepositoryInterface;
use App\Repositories\Addresses\AddressRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Invoices\InvoiceRepositoryInterface;
use App\User;

/**
 * Invoice Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class InvoiceController extends Controller
{
    protected $invoice, $address, $product, $cart;

    /**
     * Controller Construct
     *
     * @param \App\Repositories\Invoices\InvoiceRepositoryInterface  $invoice 
     * @param \App\Repositories\Addresses\AddressRepositoryInterface $address 
     * @param \App\Repositories\Products\ProductRepositoryInterface  $product 
     * @param \App\Repositories\Carts\CartRepositoryInterface        $cart 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(InvoiceRepositoryInterface $invoice, AddressRepositoryInterface $address, ProductRepositoryInterface $product, CartRepositoryInterface $cart)
    {
        $this->invoice =  $invoice;
        $this->address =  $address;
        $this->product =  $product;
        $this->cart =  $cart;
        $this->middleware('auth');
    }
    /**
     * Displays checkout page
     *
     * @param \App\User                      $user 
     * @param \App\MelaMart\Entities\Invoice $invoice 
     * @param \App\MelaMart\Entities\Cart    $cart 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(User $user, Invoice $invoice, Cart $cart)
    {
        $userId = Auth::id(); //gets current user id
        $address_id = [];
        $address_id_no = 0;
        $response = $this->checkCartInvoice($invoice, $cart);

        if (($response == false) || ($response === 'empty')) {
            return redirect()->route('cart')
                ->with('warning', 'Please review your cart before proceeding.');
        }


        $arrayInvoice = $user->find($userId)
            ->invoice()
            ->where('status', 'unpaid')
            ->get();
        $arrayAddress = $user->find($userId)->addresses;
        foreach ($arrayAddress as $address) {
            $address_id[] = $address->address_id;
        }
        if ($address_id != null) {
            $address_id_no = count($address_id);
        }

        return view(
            'store.checkout',
            [
                'array_addresses' => $arrayAddress,
                'address_id' => $address_id,
                'address_id_no' => $address_id_no,
                'invoices' => $arrayInvoice
            ]
        );
    }
    /**
     * Creates updates invoice
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        $allCartItems = $this->cart->getCartItems($request);
        $this->createInvoice($allCartItems, $request);
        return redirect()->route('invoice');
    }
    /**
     * Retrives address details for checkout
     *
     * @param int $addressId 
     *
     * @return Illuminate\Http\Response 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function show($addressId)
    {
        $userId = Auth::id(); //gets current user id
        $getAddress = $this->address->getAddress($userId, $addressId); //gets user address to be edited
        $address[] = array(
            "address_id" => $getAddress->address_id,
            'address_address' => $getAddress->address_address,
            "landmark" => $getAddress->landmark
        );
        return response()->json($address);
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
     * Checks if user has made changes to cart aftergenerating invoice
     *
     * @param \App\MelaMart\Entities\Invoice $invoice 
     * @param \App\MelaMart\Entities\Cart    $cart 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function checkCartInvoice(Invoice $invoice, Cart $cart)
    {
        $userId = Auth::id(); //gets current user id

        if (($invoice->check($userId) == null) && ($cart->check($userId) == null)) {
            $response = "empty";
            return $response;
        }

        if (array_values($invoice->check($userId)) === array_values($cart->check($userId))) {
            $response = true;
            return $response;
        } else {
            $response = false;
            return $response;
        }
    }
    /**
     * Generates invoice data & stores invoice in database
     *
     * @param array                    $allCartItems 
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function createInvoice($allCartItems, Request $request)
    {
        foreach ($allCartItems as $cart) {
            $product = $cart->product;
            if ($product->quantity != 0) {
                $price = $product->total_price;
                $cartQuantity = $cart->quantity;
                $productId = $product->id;
                $this->invoice->newInvoice($request, $productId, $cartQuantity, $price);
            }
        }
    }
}
