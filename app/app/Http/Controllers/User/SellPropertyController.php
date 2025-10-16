<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\SellPropertyUserNotification;
use App\Notifications\SellPropertyAdminNotification;
use Illuminate\Support\Facades\Notification;
use DB;
use Auth;
use Log;
use App\Models\WalletTransaction;
use App\Models\ContactDetials;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Sell;
use App\Models\Buy; 
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Str;
 
class SellPropertyController extends Controller
{
    
    public function index(){ 
        $user = Auth::user();
       
        $data['sellProperty'] = Buy::select(
            'property_id',  
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property') 
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id') 
        ->paginate(10);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' =>  $data['sellProperty']
            ]);
        }

        return view('user.pages.properties.sell.index', $data); 
    }

    public function sellProperty(Request $request)
    {
        $request->validate([ 
            'acquired_size_land' => 'required',
            'remaining_size' => 'required',
            'available_size' => 'required',
            'property_slug' => 'required',
            'calculated_size' => 'required',
            'amount' => 'required',
            'total_price' => 'required|numeric|min:1',
        ]);
         
        $user = Auth::user();
        $propertySlug = $request->input('property_slug');
        $property = Property::where('slug', $propertySlug)->first();
        
        // Check if the property exists
        if (!$property) {
            return back()->with('error', 'Property not found.');
        }

        // Generate a unique transaction reference
        $reference = 'SELLDOHREF-' . time() . '-' . strtoupper(Str::random(8));

        $selectedSizeLand = $request->input('calculated_size');
        $remainingSize = $request->input('remaining_size');
        $availableSize = $request->input('available_size');
        $amount = $request->input('total_price');

        $propertyId = $property->id;
        $propertyName = $property->name;
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        
        // Get user's buy records for this property that still have available land
        $userBuys = Buy::where('user_id', $user->id)
            ->where('property_id', $propertyId)
            ->where('remaining_size', '>', 0)
            ->orderBy('created_at', 'asc') // Sell from oldest purchases first (FIFO)
            ->get();

        // Calculate total available land from user's buys
        $totalAvailableLand = $userBuys->sum('remaining_size');
        
        // Check if user has enough land to sell
        if ($totalAvailableLand < $selectedSizeLand) {
            return back()->with('error', 'Insufficient land available for sale. You only have ' . $totalAvailableLand . ' SQM available.');
        }

        // Prepare the data to send to Paystack
        try {
            // Calculate new available size for the property
            $acquiredSizeLand = $request->input('acquired_size_land');
            $result = $property->available_size - $acquiredSizeLand;
            // Update the property's available_size
            $property->update([
                'available_size' => $result
            ]);
            // Create a transaction record for the sale (use negative amount for deduction)
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'property_id' => $propertyData->id,
                'amount' => -$amount, // Negative amount to deduct from total assets
                'reference' => $reference,
                'status' => 'completed',
                'transaction_type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
            // Create the sell record
            $sell = Sell::create([
                'property_id' => $propertyData->id,
                'property_name' => $propertyData->name,
                'transaction_id'=> $transaction->id,
                'selected_size_land' => $selectedSizeLand,
                'remaining_size' => $remainingSize,
                'available_size' => $result,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reference' => $reference,
                'total_price' => $amount,
                'status' => 'completed',
            ]);  
            
            
            
            // Deduct the sold land size from user's Buy records (FIFO)
            $landToDeduct = $selectedSizeLand;
            
            foreach ($userBuys as $buy) {
                if ($landToDeduct <= 0) break;
                
                $deductibleAmount = min($buy->remaining_size, $landToDeduct);
                
                // Update the buy record's remaining size
                $buy->update([
                    'remaining_size' => $buy->remaining_size - $deductibleAmount,
                    'selected_size_land' => $buy->selected_size_land - $deductibleAmount
                ]);
                
                $landToDeduct -= $deductibleAmount;
            } 
            
            // Top up user's wallet
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0] 
            );
            // Store balance before transaction
            $balanceBefore = $wallet->balance;
            // Update the wallet balance
            $wallet->increment('balance', $amount);

            WalletTransaction::create([
                'user_id' => $user->id, 
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'description' => 'Property sale: ' . $propertyData->name . ' - ' . $selectedSizeLand . ' SQM',
                'reference' => $reference,
                'status' => 'completed',
            ]); 

            $contactDetials = ContactDetials::first();
            
            // Notify the user
            $user->notify(new SellPropertyUserNotification($user, $propertyData, $sell, $contactDetials));
            
            // Notify the admin (support email)
            Notification::route('mail', 'customersupport@dohmayn.com')
                ->notify(new SellPropertyAdminNotification($user, $propertyData, $sell));

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'We have received your request to sell the property.',
                    'data' => $sell
                ], 201);
            }

            return redirect()->route('user.sell.history')->with('success', 'We have received your request to sell the Property, your income has been transferred to your wallet.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function sellPropertyHistory(Request $request)
    {
        $user = Auth::user();

        $sellProperties = Sell::select(
            'property_id', 'status',
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property')
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id', 'status') 
        ->paginate(10);

        // Check if request expects JSON (API/mobile)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sell Property History retrieved successfully',
                'data' => $sellProperties,
            ]);
        }

        // Otherwise, return the web view
        return view('user.pages.properties.sell.history', ['sellProperties' => $sellProperties]);
    }

  
}
 