<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        Log::debug("Checking if authenticated...");
        if (Auth::guard($guard)->check()) {
            Log::debug("Guard check passed, redirecting to /static/discounts...");
            return redirect('/static/discounts');
        }

        return $next($request);
    }
}
