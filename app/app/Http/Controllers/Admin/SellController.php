<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Sell;

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
        $sell = Sell::findOrFail(decrypt($id)); // not Post::findOrFail()
        $sell->delete();

        return redirect()->route('admin.sell.index')->with('success', 'Sell Property deleted successfully.');
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
