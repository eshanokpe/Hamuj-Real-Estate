<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Buy;
use Illuminate\Support\Facades\DB;

class BuyController extends Controller
{  
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $buys = Buy::with(['user', 'property', 'user.wallet'])
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->whereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('property', function ($propertyQuery) use ($search) {
                            $propertyQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('user_email', 'like', "%{$search}%")
                        ->orWhere('selected_size_land', 'like', "%{$search}%")
                        ->orWhere('remaining_size', 'like', "%{$search}%")
                        ->orWhere('total_price', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(20)
                ->appends(['search' => $search]);
        
        // Calculate total assets for each user and count transactions
        foreach ($buys as $buy) {
            $buy->user->total_assets = $this->calculateUserTotalAssets($buy->user);
            
            // Count associated transaction
            $buy->transaction_count = Transaction::where('id', $buy->transaction_id)->count();
        }
        
        return view('admin.home.buy.index', compact('buys', 'search'));
    }

    /**
     * Calculate total assets for a user
     */
    private function calculateUserTotalAssets($user)
    {
        if (!$user) return 0;
         
        // Total property assets (purchases - sales)
        $totalPropertyAmount = Transaction::where('user_id', $user->id)
            ->where('email', $user->email)
            ->whereNotNull('property_id')
            ->sum('amount'); 
        
        // Wallet balance
        $walletBalance = $user->wallet->balance ?? 0;
        
        // Total assets (property + wallet)
        return max(0, $totalPropertyAmount); // Ensure non-negative
    }

    public function edit($id)
    {
        $buy = Buy::findOrFail(decrypt($id));
        return view('admin.home.buy.edit', compact('buy'));
    }

    /**
     * Delete buy record and associated transaction
     */
    public function destroy($id)
    {
        try {
            $buyId = decrypt($id);
            $buy = Buy::with(['user', 'property'])->findOrFail($buyId);

            DB::transaction(function () use ($buy) {
                // Delete associated transaction if exists
                if ($buy->transaction_id) {
                    Transaction::where('id', $buy->transaction_id)->delete();
                }

                // Delete the buy record
                $buy->delete();
            });

            return redirect()->route('admin.buy.index')
                ->with('success', 'Purchase record and associated transaction deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('admin.buy.index')
                ->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple buy records and their transactions
     */
    public function destroyMultiple(Request $request)
    {
        try {
            $buyIds = array_map('decrypt', $request->buy_ids);
            
            DB::transaction(function () use ($buyIds) {
                // Get all buy records with their transaction IDs
                $buys = Buy::whereIn('id', $buyIds)->get();
                
                // Collect all transaction IDs
                $transactionIds = $buys->pluck('transaction_id')->filter()->toArray();
                
                // Delete transactions
                if (!empty($transactionIds)) {
                    Transaction::whereIn('id', $transactionIds)->delete();
                }
                
                // Delete buy records
                Buy::whereIn('id', $buyIds)->delete();
            });

            return redirect()->route('admin.buy.index')
                ->with('success', 'Selected purchase records and their transactions deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('admin.buy.index')
                ->with('error', 'Failed to delete records: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $buy = Buy::findOrFail($id);

        $updateData = [
            'status' => $request->status,
        ];

        $buy->update($updateData);

        return redirect()->route('admin.buy.index')->with('success', 'Buy Property updated successfully.');
    }
}