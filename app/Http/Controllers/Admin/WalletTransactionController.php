<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Log;

class WalletTransactionController extends Controller
{
    
    public function index()
    {
        $walletTransactions = WalletTransaction::with('user')->latest()->paginate(10); 
        return view('admin.home.walletTransaction.index', compact('walletTransactions'));
    }
    

    

   


}
