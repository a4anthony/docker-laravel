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

namespace App\Repositories\Invoices;

use Illuminate\Http\Request;
use App\MelaMart\Entities\Invoice;
use Illuminate\Support\Facades\Auth;

/**
 * Invoice Repository Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * Sets invoice to paid after payment is confirmed
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paid($userId)
    {
        Invoice::where([['user_id', $userId], ['status', 'unpaid']])->update(['status' => 'paid']);
    }
    /**
     * Retrieves unpaid invoice
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getUnpaid($userId)
    {
        return Invoice::where([['user_id', $userId], ['status', 'unpaid']])->get();
    }
    /**
     * Creates new invoice
     *
     * @param \Illuminate\Http\Request $request 
     * @param int                      $productId 
     * @param int                      $cartQuantity 
     * @param int                      $price 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function newInvoice(Request $request, $productId, $cartQuantity, $price)
    {
        $userId = Auth::id();
        if (Invoice::where([['user_id', $userId], ['status', 'unpaid']])->exists()) {
            $invoiceId = Invoice::where(
                [
                    ['user_id', $userId],
                    ['status', 'unpaid']
                ]
            )->pluck('invoice_id')->first();
        } else {
            $invoiceId = $userId . date('YmdHis');
        }


        $arrayInvoice = Invoice::where('user_id', $userId)
            ->where('status', 'unpaid')
            ->get();
        $arrayProductId = explode(',', $request->product_id);

        foreach ($arrayInvoice as $invoice) {
            Invoice::whereNotIn('product_id', $arrayProductId)->delete();
        }

        if (Invoice::where([['user_id', $userId], ['product_id', $productId], ['status', 'unpaid']])->exists()) {

            Invoice::where(
                [
                    ['user_id', $userId],
                    ['product_id', $productId],
                    ['status', 'unpaid']
                ]
            )->update(
                [
                    'quantity' => $cartQuantity,
                    'price' => $price,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                ]
            );
        } else {
            $invoice = new Invoice();
            $invoice->first_name = $request->first_name;
            $invoice->user_id = $userId;
            $invoice->last_name = $request->last_name;
            $invoice->email = $request->email;
            $invoice->invoice_id = $invoiceId;
            $invoice->phone = $request->phone;
            $invoice->status = 'unpaid';
            $invoice->product_id = $productId;
            $invoice->quantity = $cartQuantity;
            $invoice->price = $price;
            $invoice->save();
        }
    }
}
