<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status == 0) {
            Auth::logout();
            return redirect('/login')->withErrors([
                'login'=>
                'Tài khoản của bạn đã bị vô hiệu hóa.']
            );
        }
        return $next($request);
    }
}