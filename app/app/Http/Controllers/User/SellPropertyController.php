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
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
 
class SellPropertyController extends Controller
{
 
    public function index(){ 
        $user = Auth::user();
        
        // Fetch individual records
        $data['sellProperties'] = Buy::select('*')
        ->with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->orderBy('created_at', 'desc') 
        ->paginate(10);

        // Calculate Grand Totals
        $data['grandTotalSize'] = Buy::where('user_id', $user->id)
                                     ->where('user_email', $user->email)
                                     ->where('selected_size_land', '>', 0)
                                     ->sum('selected_size_land');
        
        // THIS IS THE KEY LINE FOR YOUR REQUEST
        $data['grandTotalAmount'] = Buy::where('user_id', $user->id)
                                       ->where('user_email', $user->email)
                                    //    ->where('selected_size_land', '>', 0)
                                       ->sum('total_price'); // Change to 'amount' if your DB column is named 'amount'

        return view('user.pages.properties.sell.index', $data); 
    }

    public function sellProperty(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|string',
            'buy_id'      => 'required|integer',
        ]);

        try {
            $propertyId = Crypt::decrypt($validated['property_id']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid property reference.');
        }

        $user = Auth::user();

        $buy = Buy::where('id', $validated['buy_id'])
            ->where('user_id', $user->id)
            ->where('user_email', $user->email)
            ->whereHas('property', fn ($q) => $q->where('id', $propertyId))
            ->with('property')
            ->first();

        if (! $buy) {
            return back()->with('error', 'Property record not found or does not belong to you.');
        }

        // Prevent double-selling the same buy record
        if ($buy->status === 'sold') {
            return back()->with('error', 'This property has already been sold.');
        }

        $property = $buy->property;

        $roiDueDate = Carbon::parse($buy->created_at)->addDays(365);

        if (Carbon::today()->lessThan($roiDueDate)) {
            return back()->with('error', 'This property is not yet eligible for sale. Available on ' . $roiDueDate->format('d F, Y') . '.');
        }

        $amount = $buy->total_price;
        $reference = 'SELLDOHREF-' . time() . '-' . strtoupper(Str::random(8));

        try {
            $sell = DB::transaction(function () use ($user, $buy, $property, $amount, $reference) {

                $transaction = Transaction::create([
                    'user_id'          => $user->id,
                    'email'            => $user->email,
                    'property_id'      => $property->id,
                    'amount'           => $amount,
                    'reference'        => $reference,
                    'status'           => 'completed',
                    'transaction_type' => 'sellProperty',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                $sell = Sell::create([
                    'property_id'        => $property->id,
                    'property_name'      => $property->name,
                    'transaction_id'     => $transaction->id,
                    'selected_size_land' => $buy->selected_size_land,
                    'user_id'            => $user->id,
                    'remaining_size'     => 0,
                    'user_email'         => $user->email,
                    'reference'          => $reference,
                    'total_price'        => $amount,
                    'status'             => 'completed',
                ]);

                $wallet = Wallet::firstOrCreate(
                    ['user_id' => $user->id],
                    ['balance' => 0]
                );

                $balanceBefore = $wallet->balance;
                $wallet->increment('balance', $amount);

                WalletTransaction::create([
                    'user_id'        => $user->id,
                    'wallet_id'      => $wallet->id,
                    'type'           => 'credit',
                    'amount'         => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after'  => $wallet->balance,
                    'description'    => 'Property sale: ' . $property->name . ' - ' . $buy->selected_size_land . ' SQM',
                    'reference'      => $reference,
                    'status'         => 'completed',
                ]);

                // Mark this buy as sold so it can't be sold again
                // and so the UI can flip "Sell" -> "Sold"
                $buy->update(['status' => 'sold']);

                return $sell;
            });

            $contactDetials = ContactDetials::first();

            $user->notify(new SellPropertyUserNotification($user, $property, $sell, $contactDetials, $amount));

            Notification::route('mail', 'customersupport@dohmayn.com')
                ->notify(new SellPropertyAdminNotification($user, $property, $sell, $amount));

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'We have received your request to sell the property.',
                    'data'    => $sell,
                ], 201);
            }

            return redirect()->route('user.sell.history')
                ->with('success', 'We have received your request to sell the Property, your income has been transferred to your wallet.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function sellProperty22(Request $request)
    {
         // Log all request data
        \Log::info('Request Data:', $request->all());
        
        // Log specific fields for clarity
        \Log::info('Sell Property Details:', [
            'acquired_size_land' => $request->acquired_size_land,
            'remaining_size' => $request->remaining_size,
            'available_size' => $request->available_size,
            'property_slug' => $request->property_slug,
            'calculated_size' => $request->calculated_size,
            'amount' => $request->amount,
            'total_price' => $request->total_price,
        ]);
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

       

        // Prepare the data to send to Paystack
        try { 
            
            // Create a transaction record for the sale (use negative amount for deduction)
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'property_id' => $propertyData->id,
                'amount' => $amount, // Negative amount to deduct from total assets
                'reference' => $reference,
                'status' => 'completed',
                'transaction_type' => 'sellProperty',
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
            $user->notify(new SellPropertyUserNotification($user, $propertyData, $sell, $contactDetials, $amount));
            
            // Notify the admin (support email)
            Notification::route('mail', 'customersupport@dohmayn.com')
                ->notify(new SellPropertyAdminNotification($user, $propertyData, $sell, $amount));

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

    // public function sell($id){ 
    //     $user = Auth::user(); 
       
    //     $data['property'] = Property::with(['buys' => function ($query) use ($user) {
    //         $query->where('user_id', $user->id);
    //     }])
    //     ->where('id', decrypt($id))
    //     ->firstOrFail();

    //     // --- NEW: Calculate total amount paid by this user for this property ---
    //     $data['property']->total_bought_amount = $data['property']->buys->sum('total_price');
        
    //     return view('user.pages.cart.sell_cart', $data); 
    // }

    public function sellPropertyHistory(Request $request)
    {
        $user = Auth::user();

        $sellProperties = Sell::with('property')
            ->with('valuationSummary')
            ->where('user_id', $user->id)
            ->where('user_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sell Property History retrieved successfully',
                'data' => $sellProperties,
            ]);
        }

        return view('user.pages.properties.sell.history', ['sellProperties' => $sellProperties]);
    }

  
}
 