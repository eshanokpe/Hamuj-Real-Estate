<?php
use Illuminate\Support\Facades\Auth;

function getWalletBalance()
{
    if (Auth::check()) {
        $wallet = Auth::user()->wallet;
        return $wallet ? $wallet->balance : 0;
    }
    return 0;
}