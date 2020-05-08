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

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\Orders\OrderRepositoryInterface;
use App\Repositories\Messages\MessageRepositoryInterface;
use App\Repositories\Transactions\TransactionRepositoryInterface;

/**
 * Dashboard Composer Class Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class  DashboardComposer
{
    protected $product;
    protected $message;
    protected $order;
    protected $customer;
    protected $transaction;
    /**
     * Controller Construct
     *
     * @param \App\Repositories\Products\ProductRepositoryInterface         $product 
     * @param \App\Repositories\Orders\OrderRepositoryInterface             $order 
     * @param \App\Repositories\Messages\MessageRepositoryInterface         $message 
     * @param \App\Repositories\Transactions\TransactionRepositoryInterface $transaction 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(
        ProductRepositoryInterface $product,
        OrderRepositoryInterface $order,
        MessageRepositoryInterface $message,
        TransactionRepositoryInterface $transaction
    ) {
        $this->product = $product;
        $this->order = $order;
        $this->message = $message;
        $this->transaction = $transaction;
    }
    /**
     * Undocumented function
     *
     * @param \Illuminate\View\View $view 
     *
     * @return \Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function compose(View $view)
    {

        $view->with(
            [
                //products
                'countProducts' => $this->product->countAll(),
                'countLive' => $this->product->countLive(),
                'countPaused' => $this->product->countNotLive(),
                'countNoStock' => $this->product->countNoStock(),
                //orders
                'countNew' => $this->order->countNewOrders(),
                'countShipped' => $this->order->countShippedOrders(),
                'countDelivered' => $this->order->countDeliveredOrders(),
                'countReturned' => $this->order->countReturnedOrders(),
                'amm' => $this->transaction->mothlyIncome(),
                //transactions
                'last30' => $this->transaction->last30(),
                'last7' => $this->transaction->last7(),
                'allTime' => $this->transaction->allTime(),
                'successTransc' => $this->transaction->countAll(),
                //messages
                'readMessages' => $this->message->countRead(),
                'unreadMessages' => $this->message->countUnread(),
            ]
        );
    }
}
