<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Buy;
use App\Models\Property;
use App\Models\Wallet;
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
            
            $buy->transaction_count = Transaction::where('id', $buy->transaction_id)->count();
        }

        // Calculate total selected size and percentage
        $totalSelectedSize = Buy::when($search, function ($query, $search) {
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
        ->sum('selected_size_land');
        

        $totalAvailableSize = 11057; // Your fixed total available size
        $remainingAvailableSize = $totalAvailableSize - $totalSelectedSize;
        $percentageUsed = ($totalAvailableSize > 0) ? round(($totalSelectedSize / $totalAvailableSize) * 100, 2) : 0;
        $totalAssetsSum = 0;
        $userIds = [];
        foreach ($buys as $buy) {
            $buy->user->total_assets = $this->calculateUserTotalAssets($buy->user);
            
            // Only add if user not already counted (avoid duplicates)
            if (!in_array($buy->user->id, $userIds)) {
                $totalAssetsSum += $buy->user->total_assets;
                $userIds[] = $buy->user->id;
            }
            
            $buy->transaction_count = Transaction::where('id', $buy->transaction_id)->count();
        }
        $totalPriceSum = Buy::when($search, function ($query, $search) {
            return $this->applySearchFilters($query, $search);
        })->sum('total_price');

        // Pass these to the view
         return view('admin.home.buy.index', compact(
            'buys', 
            'search', 
            'totalSelectedSize', 
            'totalAvailableSize', 
            'remainingAvailableSize',
            'percentageUsed',
            'totalAssetsSum',
            'totalPriceSum'
        ));
    }

    private function applySearchFilters($query, $search)
    {
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
    }

    /**
     * Calculate total assets for a user
     */
    private function calculateUserTotalAssets($user)
    {
        if (!$user) return 0;
          
        // Total property assets (purchases - sales)
       $totalPropertyPurchases = Transaction::where('user_id', $user->id)
            ->where('email', $user->email)
            ->where('transaction_type', 'buy')
            ->whereNotNull('property_id')
            ->sum('amount');  
        $totalPropertySales = Transaction::where('user_id', $user->id)
            ->where('email', $user->email)
            ->where('transaction_type', 'sale')
            ->whereNotNull('property_id')
            ->sum('amount');  
        $totalPropertyAmount = $totalPropertyPurchases - $totalPropertySales; 
        
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
     * Delete buy record, associated transaction, and restore property size
     */
    public function destroy($id)
    {
        try {
            $buyId = decrypt($id);
            $buy = Buy::with(['user', 'property'])->findOrFail($buyId);

            DB::transaction(function () use ($buy) {
                // Store values before deletion for reversal
                $selectedSize = $buy->selected_size_land;
                $propertyId = $buy->property_id;
                $userId = $buy->user_id;
                $totalPrice = $buy->total_price;

                // 1. Add the selected_size_land back to property's available_size
                $property = Property::find($propertyId);
                if ($property) {
                    $property->increment('available_size', $selectedSize);
                }

                // 2. Refund the amount to user's wallet (if purchase was completed)
                // if ($buy->status === 'completed') {
                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => $userId],
                        ['balance' => 0]
                    );
                    $wallet->increment('balance', $totalPrice);
                // }

                // 3. Delete associated transaction if exists
                if ($buy->transaction_id) {
                    Transaction::where('id', $buy->transaction_id)->delete();
                }

                // 4. Delete the buy record
                $buy->delete();
            });

            return redirect()->route('admin.buy.index')
                ->with('success', 'Purchase record deleted successfully. Property size restored and amount refunded to user wallet.');

        } catch (\Exception $e) {
            return redirect()->route('admin.buy.index')
                ->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple buy records and restore property sizes
     */
    public function destroyMultiple(Request $request)
    {
        try {
            $buyIds = array_map('decrypt', $request->buy_ids);
            
            DB::transaction(function () use ($buyIds) {
                // Get all buy records with their details
                $buys = Buy::with(['property'])->whereIn('id', $buyIds)->get();
                
                // Group by property for efficient size restoration
                $propertySizes = [];
                $userRefunds = [];
                
                foreach ($buys as $buy) {
                    // Collect property sizes to restore
                    if (!isset($propertySizes[$buy->property_id])) {
                        $propertySizes[$buy->property_id] = 0;
                    }
                    $propertySizes[$buy->property_id] += $buy->selected_size_land;
                    
                    // Collect user refunds for completed purchases
                    if ($buy->status === 'completed') {
                        if (!isset($userRefunds[$buy->user_id])) {
                            $userRefunds[$buy->user_id] = 0;
                        }
                        $userRefunds[$buy->user_id] += $buy->total_price;
                    }
                }
                
                // Restore property sizes
                foreach ($propertySizes as $propertyId => $sizeToAdd) {
                    Property::where('id', $propertyId)->increment('available_size', $sizeToAdd);
                }
                
                // Process refunds to user wallets
                foreach ($userRefunds as $userId => $refundAmount) {
                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => $userId],
                        ['balance' => 0]
                    ); 
                    $wallet->increment('balance', $refundAmount);
                }
                
                // Collect all transaction IDs for deletion
                $transactionIds = $buys->pluck('transaction_id')->filter()->toArray();
                
                // Delete transactions
                if (!empty($transactionIds)) {
                    Transaction::whereIn('id', $transactionIds)->delete();
                }
                
                // Delete buy records
                Buy::whereIn('id', $buyIds)->delete();
            });

            return redirect()->route('admin.buy.index')
                ->with('success', 'Selected purchase records deleted successfully. Property sizes restored and amounts refunded.');

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