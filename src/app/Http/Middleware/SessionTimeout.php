<?php

namespace App\Http\Middleware;

use App\MelaMart\Entities\AdminSession;
use Closure;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        // If user is not logged in...
        if (!Auth::check()) {
            return $next($request);
        }
        $user = Auth::guard()->user();


        $now = Carbon::now();
        $sessionLastLogin = AdminSession::where('email', $user->email)->first();
        $last_seen = Carbon::parse($sessionLastLogin->last_active);

        $absence = $now->diffInMinutes($last_seen);

        //dd($absence);
        //dd($request);
        // If user has been inactivity longer than the allowed inactivity period
        if ($absence > config('session.admin_lifetime')) {

            // Auth::logout();

            // return redirect()->route('login.admin')->with('error', 'Invalid Credentials');

            //return $next($request);

            // return redirect()->route('login.admin');
        }

        AdminSession::where('email', $user->email)
            ->update(['last_active' => Carbon::now()->format('Y-m-d H:i:s')]);

        return $next($request);
    }
}
