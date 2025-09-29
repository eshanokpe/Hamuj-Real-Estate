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
        return 0;
    }
}