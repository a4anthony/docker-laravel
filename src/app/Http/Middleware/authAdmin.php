<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Carbon\Carbon;
use App\MelaMart\Entities\AdminSession;

class authAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // If user is not logged in...
        if (!Auth::check()) {
            $check = $this->redirectTo($request);
            return redirect($check);
        }
        $user = Auth::guard()->user();

        $now = Carbon::now();
        $sessionLastLogin = AdminSession::where('email', $user->email)->first();
        $last_seen = Carbon::parse($sessionLastLogin->last_active);

        $absence = $now->diffInMinutes($last_seen);

        // If user has been inactivity longer than the allowed inactivity period
        if (($absence > config('session.admin_lifetime')) || ((auth()->user()->is_admin == null))) {
            Auth::logout();
            return redirect()->route('login.admin')
                ->with('error', 'Invalid Credentials');
        }

        AdminSession::where('email', $user->email)
            ->update(['last_active' => Carbon::now()->format('Y-m-d H:i:s')]);

        return $next($request);
    }


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->getHttpHost() == env('ADMIN_URL')) {
                return route('login.admin');
            } else {
                return route('login');
            }
        }
    }
}
