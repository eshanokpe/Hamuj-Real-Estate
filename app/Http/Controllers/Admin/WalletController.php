<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    

    public function index()
    {
        $wallets = Wallet::with('user')->latest()->paginate(10);
        return view('admin.home.wallet.index', compact('wallets'));
    }
    

    

   


}
