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
use App\User;
use App\MelaMart\Entities\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

/**
 * Password Controller Class
 *
 * @category Description
 * @package  PageLevel_Package
 * @author   Anthony Akro <anthonygakro@gmail.com>
 * @license  https://github.com/a4anthony/melamart-store/blob/master/liscence 
 *           MIT Personal License
 * @version  Release: <1.0>
 * @link     https://melamartonline.com
 */
class PasswordController extends Controller
{
    protected $user;
    /**
     * Controller Construct
     *
     * @param \App\User $user 
     * 
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Displays password reset page
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function index()
    {
        return view('auth.passwords.email');
    }
    /**
     * Sends reset password email
     *
     * @param Request $request 
     *
     * @return Illuminate\Support\Facades\Mail;
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function mail(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'exists:users,email']
            ]
        );
        $user = $this->user->where('email', '=', $request->email)->firstOrFail();
        $this->checkResetRequest($request, $user);
        $this->resetEmail($request, $user);

        return redirect()->back()->with('status', 'A reset link has been sent to your email address.');
    }
    /**
     * Shows password reset form
     *
     * @param string $token 
     *
     * @return Illuminate\View\View
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function edit($token)
    {
        $link_token = config('base_url') . 'reset/password/' . $token . '?email=' . urlencode($_GET['email']);
        return view('auth.passwords.reset', ['token' => $link_token]);
    }
    /**
     * Password reset handler
     *
     * @param Request $request 
     *
     * @return Illuminate\Support\Facades\Route
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function update(Request $request)
    {
        $this->user->resetPassword($request);
        return redirect()->route('login')->with('status', 'Password reset successful.');
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
     * Generates password reset token
     *
     * @param App\User $user 
     *
     * @return $link_token
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function generateToken($user)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uniquetoken = substr(str_shuffle($permitted_chars), 0, 60);
        $link_token = config('base_url') . 'reset/password/' . $uniquetoken . '?email=' . urlencode($user->email); //Create Password Reset Token

        return $link_token;
    }
    /**
     * Stores password reset request in database
     *
     * @param \Illuminate\Http\Request $request 
     * @param App\User                 $user 
     *
     * @return void
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function checkResetRequest(Request $request, $user)
    {
        if (PasswordReset::where('email', $request->email)->exists()) {
            //do nothing
        } else {
            PasswordReset::insert(
                [
                    'email' => $request->email,
                    'token' => $this->generateToken($user),
                    'created_at' => Carbon::now()
                ]
            );
        }
    }
    /**
     * Sends password reset email
     *
     * @param \Illuminate\Http\Request $request 
     * @param App\User                 $user 
     *
     * @return Illuminate\Support\Facades\Mail;
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    public function resetEmail(Request $request, User $user)
    {
        $tokenData = PasswordReset::where('email', $request->email)->first();
        $link = $tokenData->token;
        Mail::to($user->email)->send(new ResetPassword($user, $link));
    }
}
