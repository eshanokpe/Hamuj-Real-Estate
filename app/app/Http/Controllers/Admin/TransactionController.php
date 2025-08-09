<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    

    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(20);
        return view('admin.home.transactions.index', compact('transactions'));
    }
    

    public function edit($id)
    {
        $user = User::findOrFail(decrypt($id));
        return view('admin.home.user.edit', compact('user'));
    }

    


}