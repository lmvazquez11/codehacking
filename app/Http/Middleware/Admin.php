<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Admin
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
        //---Check if user is authenticated
        if(Auth::check()){
            if(Auth::user()->isAdmin()){
                return $next($request);
            }
        }
        //---if it is not logged in
        return redirect('/');
    }
}
