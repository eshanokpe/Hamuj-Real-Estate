<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Buy;  
use App\Models\Wallet;
use App\Models\Property;  
use App\Models\Transaction;   
use App\Models\ReferralLog;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BuyPropertiesNotification;
use App\Notifications\ReferralCommissionEarnedNotification;
use App\Notifications\ReferredUserPurchasedNotification;
 
class BuyPropertyController extends Controller
{
    
    public function walletPayment(Request $request)
    {
        $request->validate([
            
        ]); 
        $validator = Validator::make($request->all(), [
            'remaining_size' => 'required',
            'property_slug' => 'required',
            'quantity' => 'required',
            'total_price' => 'required|numeric|min:1',
            'use_referral' => 'required',
            'referral_amount' => 'required',
            // 'transaction_pin' => 'required|digits:4' 
        ]); 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        } 
        $user = Auth::user();
        $totalPrice = 0.0;
        $amount = $request->total_price;
        $commissionCheck = $request->use_referral;
        $commissionBalance = $user->commission_balance;

        if($request->use_referral){
            $totalPrice = $amount -  $commissionBalance;
        }else{
            $totalPrice = $amount;
        }
        
        // 3. Process property and payment
        $property = Property::where('slug', $request->property_slug)->first();
        if (!$property) {
            return $this->errorResponse('Property not found.', 404);
        }
    
        $selectedSizeLand = $request->quantity;
        $remainingSize = $request->remaining_size;
    
        // Check wallet balance
        $wallet = $user->wallet;
        if (!$wallet || $wallet->balance < $totalPrice) {
            return $this->errorResponse('Insufficient funds in your wallet. Please add funds to proceed.', 400);
        }
    
        // Generate transaction reference
        $reference = 'TRXDOHREF-' . strtoupper(Str::random(8));
    
        // Deduct from wallet
        $wallet->decrement('balance', $totalPrice);

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'property_id' => $property->id,
            'property_name' => $property->name,
            'amount' => $totalPrice,
            'reference' => $reference,
            'status' => 'completed',
            'source' => $request->is('api/*') ? 'mobile' : 'web',
            'payment_method' => 'wallet',
            'metadata' => [
                'property_id' => $property->id,
                'property_name' => $property->name,
                'remaining_size' => $remainingSize,
                'selected_size_land' => $selectedSizeLand,
            ],
        ]);
    
        // Process property purchase
        $buy = Buy::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'property_id' => $property->id,
            'size' => $selectedSizeLand,
            'total_price' => $totalPrice,
            'transaction_id' => $transaction->id,
            'selected_size_land' => $selectedSizeLand,
            'remaining_size' => $remainingSize,
            'use_referral' => $request->use_referral,
            'referral_amount' => $request->use_referral ? $request->referral_amount : 0,
            'status' => 'available',
        ]);
       
        if ($request->use_referral) {
            $user->decrement('commission_balance', $commissionBalance);
        }
    
        // Update property status
        $property->available_size -= $selectedSizeLand;
        if ($property->price <= 0) {
            $property->status = 'sold out';
            $buy->status = 'sold out';
            $buy->save();
        }
        $property->save();
    
        // Process referral commission
        $this->processReferralCommission($user, $property, $totalPrice, $transaction);
        
        try {
            $user->notify(new BuyPropertiesNotification($transaction, $buy));
        } catch (\Exception $e) {
            logger()->error('Payment notification error: ' . $e->getMessage());
        }
    
        return $this->successResponse([
            'message' => 'Payment successful',
            'transaction_reference' => $reference,
            'remaining_balance' => $wallet->balance,
            'purchase_details' => $buy,
            'property_status' => $property->status,
        ]);
    } 

    protected function errorResponse($message, $statusCode)
    {
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], $statusCode);
        }

        return back()->with('error', $message);
    }
    protected function successResponse($data)
    {
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json(array_merge(['status' => 'success'], $data));
        }

        return redirect()->route('user.purchases')->with('success', $data['message']);
    }
 

    public function store(Request $request)
    {   
        // Validate the request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'email' => 'required|email',
            'transaction_id' => 'required|integer|exists:transactions,id',
            'property_id' => 'required|integer|exists:properties,id',
            'selected_size_land' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'remaining_size' => 'required|string', 
            'status' => 'required|string',
        ]); 
 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        } 
       
        $user = Auth::user();

        // Create the Buy entry
        $buy = Buy::create([
            'user_id' => $request->user_id,
            'user_email' => $request->email,
            'transaction_id' => $request->transaction_id,
            'property_id' => $request->property_id,
            'selected_size_land' => $request->selected_size_land,
            'total_price' => $request->total_price,
            'remaining_size' => $request->remaining_size,
            'status' => $request->status,
        ]);
        
        // Retrieve necessary data
        $property = Property::find($request->property_id);
        $transaction = Transaction::find($request->transaction_id);
        $amount = $request->total_price;

        // Process referral commission
        $this->processReferralCommission($user, $property, $amount, $transaction);

        return response()->json([
            'status' => 'success',
            'message' => 'Buy Properties created successfully',
            'buy' => $buy,
        ], 201);
    }

    protected function processReferralCommission($user, $property, $amount, $transaction)
    {
        // Check if user has previous purchases (excluding the current transaction)
        $hasPreviousPurchases = Buy::where('user_id', $user->id)
            ->where('transaction_id', '!=', $transaction->id)
            ->exists();

        if ($hasPreviousPurchases) {
            return; // Skip commission if not first purchase
        }

        // Check if the user was referred
        $referralLog = ReferralLog::where('referred_id', $user->id)
            ->where('status', ReferralLog::STATUS_REGISTERED)
            ->first();

        if ($referralLog) {
            // Calculate 3% commission
            $commissionAmount = $amount * 0.03;

            // Update referral log
            $referralLog->update([
                'property_id' => $property->id,
                'transaction_id' => $transaction->id, // Ensure this is an ID, not a reference string
                'commission_amount' => $commissionAmount,
                'status' => ReferralLog::STATUS_PENDING,
            ]);

            // Credit referrer's wallet
            $referrer = $referralLog->referrer;
            if ($referrer) {
                $wallet = $referrer->wallet ?? $referrer->wallet()->create(['balance' => 0]); // Ensure wallet exists
                $wallet->increment('balance', $commissionAmount);

                // Create commission transaction
                Transaction::create([
                    'user_id' => $referrer->id,
                    'amount' => $commissionAmount,
                    'type' => 'referral_commission',
                    'status' => 'completed',
                    'description' => 'Commission from referral purchase',
                    'reference' => 'COMM-' . Str::uuid(),
                ]);

                // Notify referrer
                $referrer->notify(new ReferralCommissionEarnedNotification(
                    $user,
                    $property,
                    $commissionAmount
                ));

                // Notify referred user
                $user->notify(new ReferredUserPurchasedNotification(
                    $referrer,
                    $property
                ));
            }
        }
    }
}
