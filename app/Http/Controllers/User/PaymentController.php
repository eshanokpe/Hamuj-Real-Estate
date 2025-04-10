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
use App\Notifications\ReferralCommissionEarnedNotification;
use App\Notifications\ReferredUserPurchasedNotification;

class PaymentController extends Controller
{
   

    public function initializePayment(Request $request)
    {
        $request->validate([
            'remaining_size' => 'required',
            'property_slug' => 'required',
            'quantity' => 'required',
            'total_price' => 'required|numeric|min:1',
            'transaction_pin' => 'required|digits:4' // Make PIN mandatory
        ]);
    
        $user = Auth::user();
        
        // 1. FIRST CHECK: Verify if PIN is required and set
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
    
        $amount = $request->total_price;
        $selectedSizeLand = $request->quantity;
        $remainingSize = $request->remaining_size;
    
        // Check wallet balance
        $wallet = $user->wallet;
        if (!$wallet || $wallet->balance < $amount) {
            return $this->errorResponse('Insufficient funds in your wallet. Please add funds to proceed.', 400);
        }
    
        // Generate transaction reference
        $reference = 'DOHREF-' . time() . '-' . strtoupper(Str::random(8));
    
        // Deduct from wallet
        $wallet->balance -= $amount;
        $wallet->save();
    
        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'amount' => $amount,
            'reference' => $reference,
            'status' => 'completed',
            'source' => $request->is('api/*') ? 'api' : 'web',
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
            'total_price' => $amount,
            'transaction_id' => $transaction->id,
            'selected_size_land' => $selectedSizeLand,
            'remaining_size' => $remainingSize - $selectedSizeLand,
            'status' => 'available',
        ]);
    
        // Update property status
        $property->price -= $selectedSizeLand;
        if ($property->price <= 0) {
            $property->status = 'sold out';
            $buy->status = 'sold out';
            $buy->save();
        }
        $property->save();
    
        // Process referral commission
        $this->processReferralCommission($user, $property, $amount, $transaction);
    
        return $this->successResponse([
            'message' => 'Payment successful',
            'transaction_reference' => $reference,
            'remaining_balance' => $wallet->balance,
            'purchase_details' => $buy,
            'property_status' => $property->status,
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
   
    public function paymentCallback(Request $request)
    {
        try {
            $user = Auth::user();
            $paymentDetails = $this->paystack->transaction->verify([
                'reference' => $request->get('reference'),
                'trxref' => $request->get('trxref'),
            ]);
            $property = Property::where('id', $paymentDetails->data->metadata->property_id)
            ->where('name', $paymentDetails->data->metadata->property_name)->first();

            if (!$property) {
                return redirect()->back()->with('error', 'Property not found.');
            }

            if ($paymentDetails->data->status === 'success') {
                $amount = $paymentDetails->data->amount / 100;
                $reference = $paymentDetails->data->reference;
                $channel = $paymentDetails->data->channel;
                // Create the transaction record
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'property_id' => $property->id,
                    'property_name' => $property->name,
                    'amount' => $amount,
                    'status' =>  $paymentDetails->data->status,
                    'payment_method' => 'card', 
                    'reference' => $reference,
                    'transaction_state' => $paymentDetails->data->status,
                ]);
                // Create the buy record
                $buy = Buy::create([
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'transaction_id' => $transaction->id,
                    'property_id' => $property->id,
                    'selected_size_land' => $paymentDetails->data->metadata->selected_size_land,
                    'remaining_size' => $paymentDetails->data->metadata->remaining_size,
                    'total_price' => $amount,
                    'status' => 'available',
                ]);
                
                

                // Handle referral commission if this is user's first purchase
                $this->processReferralCommission($user, $property, $amount, $transaction);

                return redirect()->route('user.dashboard')->with('success', 'Payment successful!');
            }

            if ($paymentDetails->data->status !== 'success') {
                $transaction->update([
                    'status' => $paymentDetails->data->status,
                    'property_state' => 'failed',
                ]);

                return redirect()->route('user.dashboard')->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
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
            if ($referrer && $referrer->wallet) {
                $referrer->wallet->increment('balance', $commissionAmount);
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
