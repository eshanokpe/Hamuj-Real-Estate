<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Buy;


class UserAssetsController extends Controller
{ 
   public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::with(['wallet', 'buys.property']) 
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
        
        // Calculate total assets for each user (the user who made the purchase)
        foreach ($users as $user) {
            $user->total_assets = $this->calculateUserTotalAssets($user);
        }
        
        return view('admin.home.userAssets.index', compact('buys', 'search'));
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
            // ->where('payment_method', 'buy_property')
            ->whereNotNull('property_id')
            ->sum('amount');  
        
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
