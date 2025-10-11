<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $wallets = Wallet::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('balance', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);
            
        return view('admin.home.wallet.index', compact('wallets', 'search'));
    }

    /**
     * AJAX search for real-time results
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $wallets = Wallet::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('balance', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);
            
        $html = view('admin.home.wallet.search-results', compact('wallets', 'search'))->render();
        
        return response()->json([
            'html' => $html,
            'count' => $wallets->total()
        ]);
    }
}