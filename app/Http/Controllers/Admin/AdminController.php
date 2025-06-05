<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\DropdownItem;
use App\Models\Property;
use App\Models\Slider;
use App\Models\Admin;
use App\Models\Buy;
use App\Models\Sell;
use App\Models\Transfer;
use App\Models\WalletTransaction;
use App\Models\Transaction;

 
class AdminController extends Controller
{
   
    // public function __construct()
    // {
    //     $this->middleware('auth.admin');
    // } 

    public function index()
    { 
        $data = [
            'users' => User::count(),
            'properties' => Property::count(),
            'buy' => Buy::count(), 
            'buys' => Buy::latest()->paginate(3),
            'sell' => Sell::count(), 
            'sells' => Sell::latest()->paginate(3), 
            'transfer' => Transfer::count(), 
            'walletTransactions' => WalletTransaction::with('user')->latest()->paginate(3), 
            'transactions' => Transaction::with('user')->latest()->paginate(3),
        ];

        return view('admin.home.index', $data);
    }

}
