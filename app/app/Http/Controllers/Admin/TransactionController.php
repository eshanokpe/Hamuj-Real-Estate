<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
     

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $transactions = Transaction::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('source', 'like', "%{$search}%")
                    ->orWhere('property_name', 'like', "%{$search}%")
                    ->orWhere('payment_method', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);
            
        return view('admin.home.transactions.index', compact('transactions', 'search'));
    }

    /**
     * AJAX search for real-time results
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $transactions = Transaction::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('source', 'like', "%{$search}%")
                    ->orWhere('property_name', 'like', "%{$search}%")
                    ->orWhere('payment_method', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);
            
        $html = view('admin.home.transactions.partials.search-results', compact('transactions', 'search'))->render();
        
        return response()->json([
            'html' => $html,
            'count' => $transactions->total()
        ]);
    }

    /**
     * Delete a transaction
     */
    public function destroy($id)
    {
        try {
            $transactionId = decrypt($id);
            $transaction = Transaction::findOrFail($transactionId);
            
            $transaction->delete();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Failed to delete transaction: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple transactions
     */
    public function destroyMultiple(Request $request)
    {
        try {
            $transactionIds = array_map('decrypt', $request->transaction_ids);
            
            Transaction::whereIn('id', $transactionIds)->delete();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Selected transactions deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Failed to delete transactions: ' . $e->getMessage());
        }
    } 
    

    public function edit($id)
    {
        $user = User::findOrFail(decrypt($id));
        return view('admin.home.user.edit', compact('user'));
    }

    


}