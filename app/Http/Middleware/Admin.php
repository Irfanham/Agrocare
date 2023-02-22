<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

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
        if (!Auth::check()){
            return redirect()->route('login');
        }

        if (Auth::user()->role_id==2){
            return redirect()->route('expert.feede');
        }
        if (Auth::user()->role_id==3){
            return redirect()->route('farmer.feedf');
        }

        if(Auth::user()->role_id==1){
        return $next($request);
        }
    }
}
