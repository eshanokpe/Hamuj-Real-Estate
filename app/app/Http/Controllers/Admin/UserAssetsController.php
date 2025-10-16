<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Buy;
use App\Models\Sell;
use DB;


class UserAssetsController extends Controller
{  
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        })
        ->latest() 
        ->paginate(20)
        ->appends(['search' => $search]);
        
        // Calculate total assets for each user (the user who made the purchase)
        foreach ($users as $user) {
            $user->total_assets = $this->calculateUserTotalAssets($user);
            
            // Get property purchase data
            $propertyData = Buy::where('user_id', $user->id)
                ->selectRaw('COUNT(*) as properties_count, 
                            SUM(selected_size_land) as total_land_size,
                            SUM(remaining_size) as total_remaining_size')
                ->first();
                
            $user->properties_count = $propertyData->properties_count ?? 0;
            $user->total_land_size = $propertyData->total_land_size ?? 0;
            $user->total_remaining_size = $propertyData->total_remaining_size ?? 0;
            // Count transactions
            $user->transactions_count = Transaction::where('user_id', $user->id)->count();
            $user->buy_records_count = Buy::where('user_id', $user->id)->count();
            $user->sell_records_count = Sell::where('user_id', $user->id)->count();
        }
        
        return view('admin.home.userAssets.index', compact('users', 'search'));
    } 

    /**
     * Delete all transaction records for a user
     */
    public function deleteAllTransactions(Request $request, $userId)
    {
        try {
            $userId = decrypt($userId);
            $user = User::findOrFail($userId);

            DB::transaction(function () use ($user) {
                // Delete all related records
                Transaction::where('user_id', $user->id)->delete();
                Buy::where('user_id', $user->id)->delete();
                Sell::where('user_id', $user->id)->delete();

                // Optional: Reset user's wallet balance if exists
                if ($user->wallet) {
                    $user->wallet->update(['balance' => 0]);
                }
            });

            return redirect()->route('admin.userAssets.index')
                ->with('success', 'All transaction records for ' . $user->first_name . ' ' . $user->last_name . ' have been deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->route('admin.userAssets.index')
                ->with('error', 'Failed to delete transaction records: ' . $e->getMessage());
        }
    }

    /**
     * Show confirmation modal for deleting all transactions
     */
    public function showDeleteConfirmation($userId)
    {
        try {
            $userId = decrypt($userId);
            $user = User::findOrFail($userId);

            $transactionCount = Transaction::where('user_id', $user->id)->count();
            $buyCount = Buy::where('user_id', $user->id)->count();
            $sellCount = Sell::where('user_id', $user->id)->count();

            return view('admin.home.userAssets.delete-confirmation', compact('user', 'transactionCount', 'buyCount', 'sellCount'));

        } catch (\Exception $e) {
            return redirect()->route('admin.userAssets.index')
                ->with('error', 'User not found.');
        }
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
        $totalPropertyAmount = $totalPropertyPurchases + $totalPropertySales;
        // dd($totalPropertyAmount); 
        return max(0, $totalPropertyAmount); // Ensure non-negative
    }

    public function edit($id)
    {
        $buy = Buy::findOrFail(decrypt($id));
        return view('admin.home.buy.edit', compact('buy'));
    }

    public function destroy($id)
    {
        $buy = Buy::findOrFail(decrypt($id)); // not Post::findOrFail()
        $buy->delete();

        return redirect()->route('admin.buy.index')->with('success', 'Buy Property deleted successfully.');
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
