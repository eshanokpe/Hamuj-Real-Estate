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
        }
        
        return view('admin.home.userAssets.index', compact('users', 'search'));
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
