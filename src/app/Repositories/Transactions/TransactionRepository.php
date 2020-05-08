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

namespace App\Repositories\Transactions;

use Illuminate\Http\Request;
use App\MelaMart\Entities\Transactions;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMade;
use App\Repositories\Orders\OrderRepositoryInterface;
use App\Repositories\Invoices\InvoiceRepositoryInterface;
use App\Repositories\Carts\CartRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Addresses\AddressRepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Transaction Repository class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class TransactionRepository implements TransactionRepositoryInterface
{
    protected $order;
    protected $invoice;
    protected $cart;
    protected $product;
    protected $address;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Products\ProductRepositoryInterface  $product 
     * @param \App\Repositories\Orders\OrderRepositoryInterface      $order 
     * @param \App\Repositories\Invoices\InvoiceRepositoryInterface  $invoice 
     * @param \App\Repositories\Carts\CartRepositoryInterface        $cart 
     * @param \App\Repositories\Addresses\AddressRepositoryInterface $address 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(ProductRepositoryInterface $product, OrderRepositoryInterface $order, InvoiceRepositoryInterface $invoice, CartRepositoryInterface $cart, AddressRepositoryInterface $address)
    {
        $this->order = $order;
        $this->product = $product;
        $this->invoice = $invoice;
        $this->cart = $cart;
        $this->address = $address;
    }
    /**
     * Gets all Transactions
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function all()
    {
        return Transactions::latest()->get();
    }
    /**
     * Transactions all time
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function allTime()
    {
        $sum = Transactions::sum('sale_price');
        $string = '<span>&#8358;</span>' . $sum;
        return $string;
    }
    /**
     * Transaction last 30 days
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function last30()
    {
        $date = Carbon::today()->subDays(30);
        $sum = Transactions::where('created_at', '>=', $date)->sum('sale_price');
        $string = '<span>&#8358;</span>' . $sum;
        return $string;
    }
    /**
     * Transaction last 7 days
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function last7()
    {
        $date = Carbon::today()->subDays(7);
        $sum = Transactions::where('created_at', '>=', $date)->sum('sale_price');
        $string = '<span>&#8358;</span>' . $sum;
        return $string;
    }
    /**
     * Updates transactions & orders from paystack api
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateTransc()
    {
        $urlTransc = 'https://api.paystack.co/transaction';
        $chTransc = curl_init();
        curl_setopt($chTransc, CURLOPT_URL, $urlTransc);
        curl_setopt($chTransc, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $chTransc,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . env('PAYSTACK_KEY')
            ]
        );
        $requestTransc = curl_exec($chTransc);
        if (curl_error($chTransc)) {
            //echo 'error:' . curl_error($ch);
        }
        curl_close($chTransc);

        if ($requestTransc) {
            $resultTransc = json_decode($requestTransc, true);
        }
        foreach ($resultTransc as $Transaction) {
            $dataTransc[] = $Transaction;
        }

        $pageCounter  = $dataTransc[3];
        $pageCount = 1;



        for ($pageCount = 1; $pageCount <= $pageCounter['pageCount']; $pageCount++) {

            $urlTranscByPage = 'https://api.paystack.co/transaction?page=' . $pageCount . '&status=success';

            $chTranscByPage = curl_init();
            curl_setopt($chTranscByPage, CURLOPT_URL, $urlTranscByPage);
            curl_setopt($chTranscByPage, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(
                $chTranscByPage,
                CURLOPT_HTTPHEADER,
                [
                    'Authorization: Bearer ' . env('PAYSTACK_KEY')
                ]
            );
            $requestTranscByPage = curl_exec($chTranscByPage);
            if (curl_error($chTranscByPage)) {
                //echo 'error:' . curl_error($ch);
            }
            curl_close($chTranscByPage);
            $resultTranscByPage = [];
            if ($requestTranscByPage) {
                $resultTranscByPage = json_decode($requestTranscByPage, true);
            }

            foreach ($resultTranscByPage as $transaction) {
                $dataTranscByPage[] = $transaction;
            }
            $Transactions[]  = $dataTranscByPage[2];

            $arrayTransactions = $Transactions[0];

            foreach ($arrayTransactions  as $transaction) {
                $this->updateOrders($transaction);
                $this->updateTransactions($transaction);
            }
            unset($Transactions);
            unset($dataTranscByPage);
        }
    }

    /**
     * Gets monthly income
     *
     * @return array
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function mothlyIncome()
    {
        $monthId = (int) Carbon::now()->format('n');
        for ($i = 0; $i <= $monthId - 1; $i++) {
            $incomePerMonth[$i] = (int) Transactions::whereYear('created_at', '2020')->whereMonth('created_at', $i + 1)->sum('sale_price');
        }
        return $incomePerMonth;
    }
    /**
     * Creates new paystack customer
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paystackNewCustomer(Request $request)
    {
        $curl = curl_init();
        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;

        //Creates a customer via paystack api
        if ($first_name != "") {

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => "https://api.paystack.co/customer",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode(
                        [
                            'email' => $email,
                            'phone' => $phone,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                        ]
                    ),
                    CURLOPT_HTTPHEADER => [
                        "authorization: Bearer " . env('PAYSTACK_KEY'), //replace this with your own test key
                        "content-type: application/json",
                        "cache-control: no-cache"
                    ],
                )
            );

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                // there was an error contacting the Paystack API
                //die('Curl returned error: ' . $err);
            }
        }
    }
    /**
     * Initialize paystack gateway
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paystackInitialize(Request $request)
    {
        $userId = Auth::id();
        $curl = curl_init();
        $email = $request->email;
        $amount = (int) $request->amount; //the amount in kobo. This value is actually NGN 300
        $cart_items = $request->cart_items;
        $address_id = $request->address_id;
        $address = $this->address->getAddress($userId, $address_id);

        //Initiates the paystack gateway
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(
                    [
                        'amount' => $amount * 100,
                        'email' => $email,
                        'metadata' => ([
                            'custom_fields' => [
                                [
                                    'display_name' => "Invoice ID",
                                    'variable_name' => "Invoice ID",
                                    'value' => $request->invoice_id
                                ],
                                [
                                    'display_name' => "Cart Items",
                                    'variable_name' => "cart_items",
                                    'value' => $cart_items
                                ],
                                [
                                    'display_name' => "Delivery Address",
                                    'variable_name' => "address_id",
                                    'value' =>  $address->first_name . ' ' . $address->last_name . "\r\n" . $address->phone . "\r\n" . $address->address_number . "\r\n" . $address->address_address . "\r\n" . $address->address_additional
                                    //  $template = 'Hello ' . $name . ',' . "\r\n\r\n" . '<--ENTER MESSAGE HERE-->' . "\r\n\r\n" . 'Cheers!' . "\r\n\r\n" . '- MelaSpace Support Team' . "\r\n\r\n\r\n" . 'you wrote to us on ' . $date . ' at ' . $time . "\r\n" . '--------------------------------------------------' . "\r\n" . $message . "\r\n" . '--------------------------------------------------';

                                ]
                            ]
                        ])


                    ]
                ),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . env('PAYSTACK_KEY'), //replace this with your own test key
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            //die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);

        if ($tranx['status'] != true) {
            // there was an error from the API
            //print_r('API returned error: ' . $tranx['message']);
        }

        return $tranx;
    }
    /**
     * Verifies paystack transaction
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paystackVerify()
    {
        if (isset($_GET['trxref'])) {
            $trxref = $_GET['trxref'];
        }

        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $trxref;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . env('PAYSTACK_KEY')
            ]
        );
        $request = curl_exec($ch);
        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);

        if ($request) {
            $result = json_decode($request, true);
        }

        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
            $userEmail = $result['data']['customer']['email'];
            $userId = User::where('email', $userEmail)->pluck('id')->first();
            $this->cart->emptyCart($userId);
            $this->updateTransc();
            $this->invoice->paid($userId);

            $response = true;
            return $response;
            //Perform necessary action
        } else {
            echo "Transaction was unsuccessful";
        }
    }
    /**
     * Paystack webhook
     *
     * @param \Illuminate\Http\Request $request 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paystackWebhook(Request $request)
    {
        if (isset($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'])) {
            //$signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE']; [MUST VERIFY PAYSTACK SIGNATURE]

            $email = $request->input('data.customer.email');
            $user = User::where('email', $email)->first();
            $brand = $request->input('data.authorization.brand');
            $card_no = $request->input('data.authorization.last4');
            $paid_at = $request->input('data.paid_at');
            $reference = $request->input('data.reference');
        }

        $getOrders = $user->order->where('reference', $reference)->get();
        foreach ($getOrders as $order) {
            $product = $order->product;
            $images[] =  $product->images[0]->image_link;
            $item[] = $product->title;
        }

        Mail::to($email)->send(new OrderMade($user, $getOrders, $images, $item, $reference, $brand, $card_no, $paid_at));
    }
    /**
     * Count all Transactions
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function countAll()
    {
        return Transactions::count();
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
     * Updates transactions
     *
     * @param array $transaction 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateTransactions($transaction)
    {
        if (Transactions::where('reference', $transaction['reference'])->exists()) {
            //do nothing
        } else {
            $amount = $transaction['requested_amount'] / 100;
            $newTransaction = new Transactions();
            $newTransaction->reference = $transaction['reference'];
            $newTransaction->sale_price = $amount;
            $newTransaction->rate = 1.5;
            $newTransaction->commission = 0;
            $newTransaction->shipping = 0;
            if ($transaction['requested_amount'] < 2500) {
                $sale_price = $amount - ($amount * ($newTransaction->rate / 100)) - ($amount * ($newTransaction->commission / 100)) - $newTransaction->shipping;
            } else {
                $rate = ($amount * ($newTransaction->rate / 100)) + ($amount * ($newTransaction->commission / 100)) + $newTransaction->shipping + 100;
                if ($rate < 2000) {
                    $rate = $rate;
                } else {
                    $rate = 2000;
                }
                $sale_price = $amount - $rate;
            }
            $newTransaction->total = $sale_price;
            //$newTransaction->created_at =  $transaction['created_at']; //to be worked on
            $newTransaction->save();
        }
    }
    /**
     * Updates Orders
     *
     * @param array $transaction 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function updateOrders($transaction)
    {
        $reference = $transaction['reference'];
        if ($this->order->orderExists($reference)) {
            //do nothing
        } else {
            $email = $transaction['customer']['email'];
            $user = User::where('email', $email)->first();

            $invoice_id = $transaction['metadata']['custom_fields']['0']['value'];
            $address_id = $transaction['metadata']['custom_fields']['2']['value'];
            $trasc_status = $transaction['status'];
            $order_status = "new";
            $reference = $transaction['reference'];

            if ($user != null) {
                $userId = $user->id;
                $this->order->save($invoice_id, $trasc_status, $address_id, $order_status, $reference, $userId);
            }
        }
    }
}
