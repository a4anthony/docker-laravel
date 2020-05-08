<?php
/*
 *                         AMELAGROUP CONFIDENTIAL
 * __________________________________________________________________
 * 
 *  Copyright (C) 2020 AMELAGROUP - All Rights Reserved 
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Amela Group inc. and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Adobe Systems Incorporated
 * and its suppliers and may be covered by Nigerian and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Amela Group inc.
 * __________________________________________________________________

************************  FILE DESCRIPTION *************************
                        
            Insert brief description of that file does including
            any additional important information

********************************************************************
----------------------Revision History ---------------------------
Revision Date          Revised by            Revision               
-------------------------------------------------------------------
(insert date)           tonydcreator        Initial Version
-------------------------------------------------------------------
*/
namespace App\Mail;

use App\Products;
use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMade extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $getOrders, $images, $item, $reference, $brand, $card_no, $paid_at)
    {
        //
        $this->user = $user;
        $this->order = $getOrders;
        $this->images = $images;
        $this->item = $item;
        $this->reference = $reference;
        $this->brand = $brand;
        $this->card_no = $card_no;
        $this->paid_at = $paid_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@projectsbyanthony.com', 'MelaMart')
            ->subject('[TEST] Thank you for your purchase!')
            ->view('store.emails.ordermade')
            ->with([
                'customer_firstname' => $this->user->firstname,
                'customer_lastname' => $this->user->lastname,
                'customer_email' => $this->user->email,
                'getOrders' => $this->order,
                'images' => $this->images,
                'item' => $this->item,
                'reference' => $this->reference,
                'brand' => $this->brand,
                'card_no' => $this->card_no,
                'paid_at' => $this->paid_at,
            ]);
    }
}
?>