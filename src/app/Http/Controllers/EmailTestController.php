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
namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;



use Illuminate\Http\Request;

class EmailTestController extends Controller
{
    //

    public function send(Request $request)
    {
        $id = 4;
        $user = User::find($id);
        // dd($request->user());
        // Ship order...

        Mail::to('anthonygakro@gmail.com')->cc('akroanthony@gmail.com')->send(new TestEmail($user));
    }


    public function index()
    {
        return view('emails.test');
    }
}
?>