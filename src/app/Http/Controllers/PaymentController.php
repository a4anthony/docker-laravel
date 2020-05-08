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
use App\Repositories\Transactions\TransactionRepositoryInterface;

/**
 * Payment Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class PaymentController extends Controller
{
    protected $transaction;
    /**
     * Constroller Construct
     *
     * @param \App\Repositories\Transactions\TransactionRepositoryInterface $transaction 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(TransactionRepositoryInterface $transaction)
    {
        $this->transaction = $transaction;
    }
    /**
     * Initializes paystack payments
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return paystackGateway
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function initialize(Request $request)
    {
        $request->validate(
            [
                'address_id' => ['required'],
            ]
        );
        $this->transaction->paystackNewCustomer($request);
        $tranx = $this->transaction->paystackInitialize($request);
        return redirect($tranx['data']['authorization_url']);
    }
    /**
     * Payment verification
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function verify()
    {
        $verify = $this->transaction->paystackVerify();
        if ($verify ==  true) {
            return redirect()->route('cart')->with('success-payment', true);
        }
    }
    /**
     * Paystack webhook handler
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function webhook(Request $request)
    {
        $this->transaction->paystackWebhook($request);
        return response()->json('processed', 200);
    }
}
