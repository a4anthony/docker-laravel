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

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('tony@projectsbyanthony.com','Anthony at MELAMART')
                ->subject('Test Reset Password Email')
                ->view('store.emails.test');
    }
}
?>