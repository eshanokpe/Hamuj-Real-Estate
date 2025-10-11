<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Property;
use App\Models\Wallet;
use App\Models\Sell;
Use DB;

class SellController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $sells = Sell::with(['user', 'property', 'user.wallet'])
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
        
        // Calculate total assets for each user
        foreach ($sells as $sell) {
            $sell->user->total_assets = $this->calculateUserTotalAssets($sell->user);
        }
        
        return view('admin.home.sell.index', compact('sells','search'));
    }

    /**
     * AJAX search for real-time results
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $sells = Sell::with(['user', 'property', 'user.wallet'])
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
        
        // Calculate total assets for each user
        foreach ($sells as $sell) {
            $sell->user->total_assets = $this->calculateUserTotalAssets($sell->user);
        }
        
        $html = view('admin.home.sell.partials.search-results', compact('sells', 'search'))->render();
        
        return response()->json([
            'html' => $html,
            'count' => $sells->total()
        ]);
    }

    /**
     * Get search suggestions
     */
    public function suggestions(Request $request)
    {
        $search = $request->input('search');
        $suggestions = [];

        if (strlen($search) > 2) {
            // User suggestions
            $userSuggestions = Sell::with('user')
                ->whereHas('user', function($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })
                ->limit(3)
                ->get()
                ->map(function($sell) {
                    return [
                        'text' => $sell->user->first_name . ' ' . $sell->user->last_name,
                        'type' => 'User Name',
                        'icon' => 'user'
                    ];
                });

            // Property suggestions
            $propertySuggestions = Sell::with('property')
                ->whereHas('property', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->limit(3)
                ->get()
                ->map(function($sell) {
                    return [
                        'text' => $sell->property->name,
                        'type' => 'Property Name',
                        'icon' => 'building'
                    ];
                });

            // Status suggestions
            $statuses = ['completed', 'pending', 'failed'];
            $statusSuggestions = collect($statuses)
                ->filter(function($status) use ($search) {
                    return stripos($status, $search) !== false;
                })
                ->map(function($status) {
                    return [
                        'text' => $status,
                        'type' => 'Status',
                        'icon' => 'flag'
                    ];
                });

            $suggestions = $userSuggestions
                ->merge($propertySuggestions)
                ->merge($statusSuggestions)
                ->take(5)
                ->unique('text')
                ->values();
        }

        return response()->json([
            'suggestions' => $suggestions
        ]);
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
        $sell = Sell::findOrFail(decrypt($id));
        return view('admin.home.sell.edit', compact('sell'));
    }

    public function destroy($id)
    {
        try {
            $sellId = decrypt($id);
            $sell = Sell::with(['user', 'property'])->findOrFail($sellId);

            DB::transaction(function () use ($sell) {
                // Store values before deletion for reversal
                $userId = $sell->user_id;
                $propertyId = $sell->property_id;
                $soldSize = $sell->selected_size_land;
                $totalPrice = $sell->total_price;

                // 1. Deduct the payment from user's wallet
                $wallet = Wallet::firstOrCreate(
                    ['user_id' => $userId],
                    ['balance' => 0]
                );

                // Store balance before transaction for audit
                $balanceBefore = $wallet->balance;

                // Deduct the amount from wallet
                $wallet->decrement('balance', $totalPrice);
                
                // 2. Add the sold size back to property's available size
                $property = Property::find($propertyId);
                if ($property) {
                    $property->increment('available_size', $soldSize);
                }

                // 3. Delete any associated transactions
                if ($sell->transaction_id) {
                    Transaction::where('id', $sell->transaction_id)->delete();
                }

                // 4. Delete the sell record
                $sell->delete();

                // Optional: Log the reversal transaction
                $this->logReversalTransaction($userId, $totalPrice, $balanceBefore, $wallet->balance, $propertyId, $soldSize);
            });

            return redirect()->route('admin.sell.index')
                ->with('success', 'Sold property deleted successfully. Payment deducted from user wallet and property size restored.');

        } catch (\Exception $e) {
            return redirect()->route('admin.sell.index')
                ->with('error', 'Failed to delete sold property: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple sold properties with reversal
     */
    public function destroyMultiple(Request $request)
    {
        try {
            $sellIds = array_map('decrypt', $request->sell_ids);
            
            DB::transaction(function () use ($sellIds) {
                $sells = Sell::with(['user', 'property'])->whereIn('id', $sellIds)->get();
                
                foreach ($sells as $sell) {
                    // Store values for reversal
                    $userId = $sell->user_id;
                    $propertyId = $sell->property_id;
                    $soldSize = $sell->selected_size_land;
                    $totalPrice = $sell->total_price; 

                    // 1. Deduct from user's wallet
                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => $userId],
                        ['balance' => 0]
                    ); 
                    $wallet->decrement('balance', $totalPrice);

                    // 2. Add size back to property
                    $property = Property::find($propertyId);
                    if ($property) {
                        $property->increment('available_size', $soldSize);
                    }

                    // 3. Delete associated transactions
                    if ($sell->transaction_id) {
                        Transaction::where('id', $sell->transaction_id)->delete();
                    }

                    // 4. Delete the sell record
                    $sell->delete();

                    // Log reversal
                    $this->logReversalTransaction($userId, $totalPrice, $wallet->balance + $totalPrice, $wallet->balance, $propertyId, $soldSize);
                }
            });

            return redirect()->route('admin.sell.index')
                ->with('success', 'Selected sold properties deleted successfully. Payments deducted from user wallets and property sizes restored.');

        } catch (\Exception $e) {
            return redirect()->route('admin.sell.index')
                ->with('error', 'Failed to delete sold properties: ' . $e->getMessage());
        }
    }

    /**
     * Log reversal transaction for audit purposes
     */
    private function logReversalTransaction($userId, $amount, $balanceBefore, $balanceAfter, $propertyId, $size)
    {
        // You can create a reversal transaction record or log this activity
        // This is optional but recommended for audit trails
        
        Transaction::create([
            'user_id' => $userId,
            'type' => 'reversal',
            'transaction_type' => 'sale_reversal',
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'status' => 'completed',
            'description' => "Sale reversal - {$size} SQM property sale deleted by admin",
            'reversal_reason' => 'Admin deleted sale record',
            'reversed_by' => 'admin',
            'property_id' => $propertyId,
            'reference' => 'RVSL-' . time() . '-' . $userId,
            'source' => 'admin_panel'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required',
        ]);

        $sell = Sell::findOrFail(decrypt($id));

        $updateData = [
            'status' => $request->status,
        ];

        $sell->update($updateData);

        return redirect()->route('admin.sell.index')->with('success', 'Sell Property updated successfully.');
    }

}
