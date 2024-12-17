<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;

class WalletBalance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */ 
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $wallet = Auth::user()->wallet; // Access wallet relationship
            $balance = $wallet ? $wallet->balance : 0;
            View::share('walletBalance', $balance);
            View::share('walletCurrency', $wallet->currency);
        } else {
            View::share('walletBalance', 0);
        }

        return $next($request);
    }
}
