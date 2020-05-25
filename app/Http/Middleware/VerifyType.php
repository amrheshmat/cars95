<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class VerifyType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$type)
    {
        $member = Auth::guard('member')->user();
        if(!$member || !in_array($member->type, $type))
            throw new AuthorizationException('This action is unauthorized.');
        
        return $next($request);
    }
}
