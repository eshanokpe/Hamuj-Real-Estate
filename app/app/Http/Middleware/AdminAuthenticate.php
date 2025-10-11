<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;


class AdminAuthenticate
{
    public function handle($request, Closure $next)
    { 
        if (Auth::guard('admin')->check()) {
            return $next($request);
        } 

        return redirect()->route('admin.login');
    }
}
