<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class UserMiddleware
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
        if(Auth::check() && Auth::user()->status_ban){
            $banned = Auth::user()->status_ban=='1';
            Auth::logout();
            if ($banned== 1){
                $message = "Akun anda diblokir. Hubungi Admin!";
            }
            return redirect()->route('login')->with('status',$message)->withErrors(['email'=>'Akun anda diblokir. Hubungi Admin!']);
        }
        return $next($request);
    }
}
