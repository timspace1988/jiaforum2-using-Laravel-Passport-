<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
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
        //Three checks
        //1. if user has logged in
        //2. if user has not done email verification
        //3. if user's request is not email verification  nor logout
        if($request->user() && ! $request->user()->hasVerifiedEmail() && ! $request->is('email/*', 'logout')){
            return $request->expectsJson() ? abort(403, 'Your email address is not verified.') : redirect()->route('verification.notice');//return different result based on user's client
        }
        return $next($request);
    }
}
