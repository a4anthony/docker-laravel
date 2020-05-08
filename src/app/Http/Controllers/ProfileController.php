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
use App\User;
use Illuminate\Support\Facades\Auth;
use App\MelaMart\Entities\Product;
use App\Repositories\Addresses\AddressRepositoryInterface;
use App\Repositories\Feedbacks\FeedbackRepositoryInterface;
use App\Repositories\Orders\OrderRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Profile Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class ProfileController extends Controller
{
    protected $address, $feedback, $order;
    /**
     * Controller Construct
     *
     * @param \App\User                                               $user 
     * @param \App\Repositories\Addresses\AddressRepositoryInterface  $address 
     * @param \App\Repositories\Feedbacks\FeedbackRepositoryInterface $feedback 
     * @param \App\Repositories\Orders\OrderRepositoryInterface       $order 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(
        User $user,
        AddressRepositoryInterface $address,
        FeedbackRepositoryInterface $feedback,
        OrderRepositoryInterface $order
    ) {
        $this->user = $user;
        $this->address = $address;
        $this->feedback = $feedback;
        $this->order = $order;
        $this->middleware('auth');
    }
    /**
     * Handles all index request to controller
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $user = $this->user->find($userId);
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        $url = str_replace('account', '', $request->path());
        if ($url == "") {
            $url = '.dashboard';
        }
        $arrayOrders = [];
        if ((!isset($_GET['reference'])) && ($request->path() == 'account/orders')) {
            $arrayOrdersByReference = $this->order->customerOrders($userId);
            foreach ($arrayOrdersByReference as $key => $orders) {
                $reference = $key;
                $orders[] = $orders;
                $arrayOrders[] = [$reference => $orders];
            }
            $myCollectionObj = collect($arrayOrders);
            $arrayOrders = $this->paginate($myCollectionObj);
            $url = 'orders-group';
        } elseif (isset($_GET['reference'])) {
            $reference = $_GET['reference'];
            $arrayOrders = $user->orders()->where('reference', $reference)->paginate(4);
        }

        return view(
            'store.Profile.' . $url,
            [
                'user' => $user,
                'arrayOrders' => $arrayOrders,
                'arrayAddresses' => $user->addresses()->paginate(4),
                'arrayWishlist' => $user->wishlist()->paginate(4),
                'arrayOrdersByReference' => $arrayOrders
            ]
        );
    }
    /**
     * Displays create records
     *
     * @param \Illuminate\Http\Request       $request 
     * @param \App\MelaMart\Entities\Product $product 
     * @param string                         $identifier 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function create(Request $request, Product $product, $identifier = "")
    {
        return $this->urlFilter($request, $identifier, $product);
    }
    /**
     * Stores new records in database
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        if (strpos($request->path(), 'feedback') !== false) {
            $this->feedback->addFeedback($request);
            return redirect()->route('orders')->with('success', 'Feedback submitted');
        } elseif (strpos($request->path(), 'address') !== false) {
            $this->address->addAddress($userId, $request);
            return $this->redirectRoute($request);
        }
    }
    /**
     * Displays individual records
     *
     * @param \Illuminate\Http\Request       $request 
     * @param \App\MelaMart\Entities\Product $product 
     * @param string                         $identifier 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function show(Request $request, Product $product, $identifier = "")
    {
        return $this->urlFilter($request, $identifier, $product);
    }
    /**
     * Displays form to edit records
     *
     * @param \Illuminate\Http\Request       $request 
     * @param \App\MelaMart\Entities\Product $product 
     * @param string                         $identifier 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function edit(Request $request, Product $product, $identifier = "")
    {
        if (isset($_GET['prev_url'])) {
            $redirectUrl = $_GET['prev_url'];
        } else {
            $redirectUrl = "";
        }
        return $this->urlFilter($request, $identifier, $product, $redirectUrl);
    }
    /**
     * Updates records in database
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        if (strpos($request->path(), 'details') !== false) {
            $this->user->userUpdate($userId, $request);
            return redirect()->route('profile');
        } elseif (strpos($request->path(), 'address') !== false) {
            $this->address->updateAddress($userId, $request);

            if ($request->prev_url != null) {
                return redirect()->route('invoice');
            } else {
                return $this->redirectRoute($request);
            }
        } elseif (strpos($request->path(), 'password') !== false) {
            $this->user->changePassword($request);
            return redirect()->route('profile');
        }
    }
    /**
     * Deletes records from databse
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function destroy(Request $request)
    {
        $userId = Auth::id(); //gets user id
        $this->address->deleteAddress($userId, $request); //deletes user address
        return redirect()->route('address')->with('success', 'Address deleted successfully.');
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
     * Redirects to route after store & update
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function redirectRoute(Request $request)
    {
        if ($request->ajax()) {
            //do nothing
        } else {
            if (strpos(url()->previous(), 'checkout')) {
                return redirect(url()->previous())->with('success', 'Address added successfully.');
            } else {
                return redirect()->route('address')->with('success', 'Address added successfully.');
            }
        }
    }
    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request $request 
     * @param int                      $identifier 
     * @param \App\Product             $product 
     * @param string                   $redirectUrl 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function urlFilter(Request $request, $identifier, $product, $redirectUrl = "")
    {
        $userId = Auth::id();
        $user = $this->user->find($userId);
        if ($identifier != "") {
            $stripIdentifier = str_replace('/' . $identifier, '', $request->path());
        } else {
            $stripIdentifier = $request->path();
        }
        $urlPath = str_replace('account/', '', $stripIdentifier);
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $urlPath);
        if ($url == "") {
            $url = '.dashboard';
        }
        if (($url == 'orders-feedback') && !$user->orders()->where('product_id', $identifier)->exists()) {
            abort(404, 'Page not found');
        }
        return view(
            'store.Profile.' . $url,
            [
                'user' => $user,
                'arrayOrders' => $user->orders()->paginate(2),
                'product' => $product->find($identifier),
                'address' => $this->address->getAddress($userId, $identifier),
                'redirectUrl' => $redirectUrl || null
            ]
        );
    }
    /**
     * Pagination method
     *
     * @param array $items 
     * @param int   $perPage 
     * @param int   $page 
     * @param array $options 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paginate($items, $perPage = 4, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
