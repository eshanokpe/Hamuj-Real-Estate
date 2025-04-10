<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class WalletService
{
    public function getWalletBalance()
    {
        if (Auth::check()) {
            $wallet = Auth::user()->wallet;
            return $wallet;
        }
        // if (Auth::check()) {
        //     $wallet = Auth::user()->wallet;
        //     $balance = $wallet ? $wallet->balance : 0;
        //     $view->with('wallet', $wallet);
        // } else {
        //     $view->with('wallet', 0);
        // }
        return 0;
    }
}