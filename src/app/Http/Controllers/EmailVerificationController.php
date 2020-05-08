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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerify;
use App\User;

/**
 * EmailVerification Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class EmailVerificationController extends Controller
{
    /**
     * Send verification email handler
     *
     * @param \App\User $user  
     * 
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function sendVerificationEmail(User $user)
    {
        $userId = Auth::id();
        $user = $user->find($userId);
        Mail::to($user->email)->send(new EmailVerify($user)); //sends verification email to customers

        return redirect()->route('profile')
            ->with('success', 'A verification link has been sent to your email.');
    }
    /**
     * Email verification handler
     *
     * @param \App\User $user 
     * @param string    $token 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function verifyEmail(User $user, $token)
    {
        $user = $user->where('token', $token)->first();
        $userId = $user->id;
        if ($user->email_verified_at == null) {
            $user->emailVerify($userId, $token);

            return view('auth.verify');
        } else {
            return redirect()->route('home');
        }
    }
}
