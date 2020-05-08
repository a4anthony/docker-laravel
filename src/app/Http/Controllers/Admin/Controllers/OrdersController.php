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

namespace App\Http\Controllers\Admin\Controllers;

use App\MelaMart\Entities\Order;
use Illuminate\Http\Request;
use App\Repositories\Orders\OrderRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Users\UserRepositoryInterface;

/**
 * Order Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class OrdersController extends Controller
{
    protected $order;
    protected $product;
    protected $user;
    protected $address;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Orders\OrderRepositoryInterface     $order 
     * @param \App\Repositories\Products\ProductRepositoryInterface $product 
     * @param \App\Repositories\Users\UserRepositoryInterface       $user 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(OrderRepositoryInterface $order, ProductRepositoryInterface $product, UserRepositoryInterface $user)
    {
        $this->order = $order;
        $this->product = $product;
        $this->user = $user;
        $this->middleware('authAdmin');
    }
    /**
     * Handle all get request
     *
     * @param \Illuminate\Http\Request     $request 
     * @param \App\MelaMart\Entities\Order $order 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request, Order $order)
    {
        $url = $this->urlFormat($request);

        return view(
            'admin.' . $url,
            ['allOrders' => $this->order->orders($url)]
        );
    }

    /**
     * Gets order by reference code
     *
     * @param string $reference 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function show($reference)
    {
        $arrayOrders = $this->order->getOrder($reference);

        foreach ($arrayOrders as $orders) {
            foreach ($orders as $order) {
                $user = $order->customer;
                $total = $order->total($order);
                $address = $order->address;
                $reference = $order->reference;
                $status = $order->order_status;
            }
        }

        return view(
            'admin.orders.view',
            [
                'allOrders' => $arrayOrders,
                'user' => $user,
                'no_Items' => count($orders),
                'orderTotal' => $total,
                'address' => $address,
                'reference' => $reference,
                'status' => $status
            ]
        );
    }
    /**
     * Gets user orders
     *
     * @param int $userId 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function userOrders($userId)
    {
        $user = $this->user->find($userId);
        $arrayOrders = $this->order->getUserOrders($userId);
        $totalOrders = 0;
        $allTimeTotal = 0;
        if (!$arrayOrders->isEmpty()) {

            foreach ($arrayOrders as $orders) {
                foreach ($orders as $order) {
                    $user = $order->customer;
                    $totalOrders = $order->totalOrders($user);
                    $allTimeTotal = $order->allTimeTotal($user);
                }
            }
        }

        return view(
            'admin.orders.byCustomer',
            [
                'allOrders' => $arrayOrders,
                'user' => $user,
                'totalOrders' => $totalOrders,
                'allTimeTotal' => $allTimeTotal
            ]
        );
    }
    /**
     * Updates order status
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update(Request $request)
    {
        $url = $this->urlFormat($request);
        $this->order->updateOrder($request, $url);
        return redirect('/order/' . $request->reference)
            ->with('success', 'Order status has been updated');
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
     * Formats url string
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return string
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function urlFormat(Request $request)
    {
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        $url = str_replace('-', '.', $url);
        return $url;
    }
}
