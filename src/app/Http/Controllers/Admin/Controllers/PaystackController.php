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

use App\Repositories\Transactions\TransactionRepositoryInterface;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Paystack Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class PaystackController extends Controller
{
    protected $customer, $transaction, $user;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Transactions\TransactionRepositoryInterface $transaction 
     * @param \App\Repositories\Users\UserRepositoryInterface               $user 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(TransactionRepositoryInterface $transaction, UserRepositoryInterface $user)
    {
        $this->transaction = $transaction;
        $this->user = $user;
        $this->middleware('authAdmin');
    }
    /**
     * Handles all get requests
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index(Request $request)
    {
        $url = preg_replace('/[^a-zA-Z0-9]/', '-', $request->path());
        $url = str_replace('-', '.', $url);

        return view(
            'admin.' . $url . '.index',
            [
                'allCustomers' => $this->user->all(),
                'allTransactions' => $this->transaction->all(),
            ]
        );
    }
}
