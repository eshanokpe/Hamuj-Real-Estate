<?php

namespace App\Http\Controllers\User;

use Auth;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Models\Buy;  
use App\Models\Wallet;
use App\Models\Property;  
use App\Models\Transaction;   
use App\Models\ReferralLog;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BuyPropertiesNotification;
use App\Notifications\ReferralCommissionEarnedNotification;
use App\Notifications\ReferredUserPurchasedNotification;

class PaymentController extends Controller
{
   

public function initializePayment(Request $request)
{
    Log::warning('totalLand:222' . json_encode($request->all()));

    $request->validate([
        'remaining_size' => 'required|numeric|min:0', // Added numeric validation
        'property_slug' => 'required',
        'quantity' => 'required|numeric|min:0.0001', // Added numeric validation and minimum
        'total_price' => 'required|numeric|min:1',
        'commission_applied_amount' => 'required|numeric|min:0', 
        'transaction_pin' => 'required|digits:4',
        'payment_method' => 'required|string|in:wallet,card',
    ]); 
    
    $user = Auth::user();
    $commissionToApply = 0.0; 
    $finalAmountPayable = 0.0;
    $commissionAppliedFromRequest = $request->commission_applied_amount;
    $finalAmountFromRequest = $request->total_price;
    $applyCommission = $request->commission_check;
    $commissionAvailable = $user->commission_balance;
  
    if($applyCommission == 'on'){
        $finalAmountPayable = $finalAmountFromRequest -  $commissionAvailable;
    } else {
        $finalAmountPayable = $finalAmountFromRequest;
    }
   
    if (config('app.enable_transaction_pin')) {
        if (empty($user->transaction_pin)) {
            return $this->errorResponse('Please set your transaction PIN first.', 403, [
                'redirect_url' => route('user.transaction.pin'),
                'requires_pin_setup' => true
            ]);
        }
    }

    // 2. SECOND CHECK: Verify the provided PIN
    if (!Hash::check($request->transaction_pin, $user->transaction_pin)) {
        // Track failed attempts
        $user->increment('failed_pin_attempts');
        $user->update(['last_failed_pin_attempt' => now()]);
        
        $remainingAttempts = max(0, 3 - $user->failed_pin_attempts);
        
        if ($remainingAttempts <= 0) {
            $lockoutTime = now()->addMinutes(15);
            $user->update(['pin_locked_until' => $lockoutTime]);
            
            return $this->errorResponse('Too many failed attempts. Try again after 15 minutes.', 429, [
                'lockout_time' => $lockoutTime->toDateTimeString()
            ]);
        }
        
        return $this->errorResponse('Invalid transaction PIN', 401, [
            'attempts_remaining' => $remainingAttempts
        ]);
    }

    // Reset attempt counter on successful verification
    $user->update([
        'failed_pin_attempts' => 0,
        'last_failed_pin_attempt' => null,
        'pin_locked_until' => null
    ]);

    // 3. Process property and payment
    $property = Property::where('slug', $request->property_slug)->first();
    if (!$property) {
        return $this->errorResponse('Property not found.', 404);
    }

    // FIX: Ensure numeric values and handle null/empty values
    $selectedSizeLand = floatval($request->quantity);
    $remainingSize = floatval($request->remaining_size);
    
    // Additional validation for numeric values
    if ($selectedSizeLand <= 0) {
        return $this->errorResponse('Invalid land size selected.', 400);
    }

    // FIX: Ensure property available_size is a valid number
    $currentAvailableSize = floatval($property->available_size);
    if ($currentAvailableSize < 0) {
        $currentAvailableSize = 0;
    }

    // Check if selected size exceeds available size
    if ($selectedSizeLand > $currentAvailableSize) {
        return $this->errorResponse('Selected land size exceeds available property size.', 400);
    }

    // Check wallet balance
    $wallet = $user->wallet;
    if (!$wallet || $wallet->balance < $finalAmountPayable) {
        return $this->errorResponse('Insufficient funds in your wallet. Please add funds to proceed.', 400);
    }

    // Generate transaction reference
    $reference = 'TRXDOHREF-' . strtoupper(Str::random(8));

    // Deduct from wallet
    $wallet->decrement('balance', $finalAmountPayable);

    // Calculate new remaining size
    $newRemainingSize = $currentAvailableSize - $selectedSizeLand;
    if ($newRemainingSize < 0) {
        $newRemainingSize = 0;
    }

    // Create transaction record
    $transaction = Transaction::create([
        'user_id' => $user->id,
        'email' => $user->email,
        'transaction_type' => 'buy',
        'property_id' => $property->id,
        'property_name' => $property->name,
        'amount' => $finalAmountPayable,
        'reference' => $reference,
        'status' => 'completed', 
        'source' => $request->is('api/*') ? 'mobile' : 'web',
        'payment_method' => 'wallet',
        'metadata' => [
            'property_id' => $property->id,
            'property_name' => $property->name,
            'remaining_size' => $newRemainingSize,
            'selected_size_land' => $selectedSizeLand,
            'payment_method' => 'wallet',
            'property_mode' => 'buy_property',
            'original_available_size' => $currentAvailableSize,
        ],
    ]);

    // Process property purchase
    $buy = Buy::create([
        'user_id' => $user->id,
        'user_email' => $user->email,
        'property_id' => $property->id,
        'size' => $selectedSizeLand,
        'total_price' => $finalAmountPayable,
        'transaction_id' => $transaction->id,
        'selected_size_land' => $selectedSizeLand,
        'remaining_size' => $newRemainingSize,
        'status' => 'available',
        'use_referral' => $request->applyCommission == "on"  ? 1 : 0,
        'referral_amount' => $request->applyCommission == "on" ? $commissionAvailable : 0,
    ]);

    if ($request->boolean('commission_check')) {
        $user->decrement('commission_balance', $commissionAppliedFromRequest);
    }

    // FIX: Update property available_size safely
    $property->available_size = $newRemainingSize;
    
    if ($property->available_size <= 0) {
        $property->status = 'sold out';
        $buy->status = 'sold out';
        $buy->save();
    } 
    
    $property->save();
    
    $this->processReferralCommission($user, $property, $finalAmountPayable, $transaction);
    
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
        'new_available_size' => $property->available_size,
    ]); 
}

    // Helper methods for PIN attempt tracking
    private function getRemainingAttempts($user)
    {
        $maxAttempts = config('auth.pin.max_attempts', 3);
        $attempts = $user->failed_pin_attempts ?? 0;
        return max(0, $maxAttempts - $attempts - 1);
    }

    private function getLockoutTime($user)
    {
        $lastAttempt = $user->last_failed_pin_attempt;
        if (!$lastAttempt) return null;
        
        $lockoutMinutes = config('auth.pin.lockout_minutes', 15);
        return $lastAttempt->addMinutes($lockoutMinutes);
    }
    private function resetPinAttempts($user)
    {
        $user->update([
            'failed_pin_attempts' => 0,
            'last_failed_pin_attempt' => null
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
   
   
    protected function processReferralCommission($user, $property, $amount, $transaction)
    {
        // Check if user has any previous purchases
        $hasPreviousPurchases = Buy::where('user_id', $user->id)
        ->where('transaction_id', '!=', $transaction->id)
        ->exists();

        if ($hasPreviousPurchases) {
            return; // Skip if not first purchase
        }

        // Check if user was referred
        $referralLog = ReferralLog::where('referred_id', $user->id)
            ->where('status', ReferralLog::STATUS_REGISTERED)
            ->first();
        if ($referralLog) {
            // Calculate 3% commission
            $commissionAmount = $amount * 0.03;

            // Update referral log
            $referralLog->update([
                'property_id' => $property->id,
                'transaction_id' => $transaction->id,
                'commission_amount' => $commissionAmount,
                'status' => ReferralLog::STATUS_PENDING,
            ]);
            // Credit referrer's wallet
            $referrer = $referralLog->referrer;
            if ($referrer) {
                 // Add commission to commission_balance field
                $referrer->increment('commission_balance', $commissionAmount);

                // Create commission transaction
                Transaction::create([
                    'user_id' => $referrer->id,
                    'amount' => $commissionAmount,
                    'type' => 'referral_commission',
                    'status' => 'completed',
                    'description' => 'Commission from referral purchase',
                    'reference' => 'COMM-'.Str::uuid(),
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
            }else {
                // Create a wallet if it doesn’t exist (optional)
                $referrer->wallet()->create(['balance' => $commissionAmount]);
            }
        }
    }
}
