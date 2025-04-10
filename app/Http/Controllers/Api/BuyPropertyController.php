<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Buy;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\ReferralLog;
use App\Notifications\ReferralCommissionEarnedNotification;
use App\Notifications\ReferredUserPurchasedNotification;
 
class BuyPropertyController extends Controller
{
    /**
     * Store a new transaction.
     */
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
