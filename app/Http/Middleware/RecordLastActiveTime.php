<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RecordLastActiveTime
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
        //Check if user has signed in
        if(Auth::check()){
            //Record the last active time
            Auth::user()->recordLastActiveAt();
        }
        return $next($request);
    }
}
