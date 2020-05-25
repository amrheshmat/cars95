<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

        if ($guard == "member" && Auth::guard($guard)->check()) {
            return redirect('/');
        }

        if (Auth::guard($guard)->check() && $guard == 'user') {
            return redirect('/dashboard');
        }
       

        return $next($request);
    }
}
