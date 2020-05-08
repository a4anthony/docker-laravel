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

/**
 * Invoice Repository Interface
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
interface InvoiceRepositoryInterface
{
    /**
     * Sets invoice to paid after payment is confirmed
     *
     * @param int $userId 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function paid($userId);
    /**
     * Retrieves unpaid invoice
     *
     * @param int $userId 
     *
     * @return collection
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function getUnpaid($userId);
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
    public function newInvoice(Request $request, $productId, $cartQuantity, $price);
}
