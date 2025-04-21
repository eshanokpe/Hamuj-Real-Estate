<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Transaction;
use App\Notifications\WalletFundedNotification;
use App\Notifications\WalletTransferNotification;
use Illuminate\Support\Facades\Auth;
   

class WebhookController extends Controller
{
    

    public function handlePaystackWebhook(Request $request)
    {
        $paystackSecretKey = env('PAYSTACK_SECRET_KEY');
        $signature = $request->header('X-Paystack-Signature');
        $input = $request->getContent();

        if (!$signature || $signature !== hash_hmac('sha512', $input, $paystackSecretKey)) {
            Log::error('Invalid signature:', ['signature' => $signature]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $event = json_decode($input);
        if (!$event) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }
        Log::info('Funding Webhook Received', (array) $event);
        switch ($event->event) {
            case 'transfer.success':
                $this->handleTransferSuccess($event->data);
                break;
            case 'charge.success':
                $this->handleChargeSuccess($event->data);
                break;
            default:
                Log::warning('Unhandled Paystack Event: ' . $event->event);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function handleChargeSuccess($data)
    {
        // Example: Process the payment data
        Log::info('Charge Successful', (array) $data);

        // Check metadata for mobile app identifier
        $isMobileApp = isset($data->metadata->source) && 
        $data->metadata->source === 'mobile_app';

        if ($isMobileApp) {
            Log::info("Skipping mobile app payment: {$data->reference}");
            return;
        }

        // Rest of your webhook processing...
        $user = User::where('email', $data->customer->email)->first();
        if (!$user) {
            Log::warning("User not found: {$data->customer->email}");
            return;
        }

        $email = $data->customer->email;
        $amount = $data->amount / 100; // Convert amount to Naira (Paystack sends amount in kobo)
        $reference = $data->reference;
        $status = $data->status;
        $customerName = $data->customer->first_name . ' ' . $data->customer->last_name;

        $user = User::where('email', $email)->first();
        if ($user) {
            // Update the wallet balance
            $amount = $data->amount / 100;
            $user->wallet->increment('balance', $amount); 
 
            // Log the transaction
            Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'transaction_type' => 'wallet',
                'reference' => $reference,
                'status' => $status,
                'description' => 'Fund added to wallet',
                'payment_method' => 'wallet',
                'recipient_name' => $customerName,
                'source' => 'web',
                'metadata' => json_encode($data->metadata ?? null),
            ]);  
            // Trigger the notification
            $newBalance = $user->wallet->balance;
            $user->notify(new WalletFundedNotification($amount, $newBalance, $reference));

            Log::info("Wallet updated successfully for user: {$email}");
        } else {
            Log::warning("User with email {$email} not found.");
        }

    }

    protected function handleTransferSuccess($data)
    {
        Log::info('Transfer Successful', (array) $data);
        $amount = $data->amount / 100; // Convert amount from kobo to Naira
        $status = $data->status;
        $reason = $data->reason ?? 'No reason provided';
        $currency = $data->currency;
        $transferCode = $data->transfer_code;
        $recipient = $data->recipient;
    
        // Extract recipient details
        $recipientName = $recipient->name ?? 'Unknown Name';
        $recipientCode = $recipient->recipient_code ?? 'Unknown Code';
        $accountNumber = $recipient->details->account_number ?? 'Unknown Account Number';
        $accountName = $recipient->details->account_name ?? 'Unknown Account Name';
        $bankName = $recipient->details->bank_name ?? 'Unknown Bank';

        $reference = $data->reference;
       
        $user = Auth::user();
        $userWallet = $user->wallet;

        $user = User::where('email', $user->email)->first();
        if ($user) {
            // $user->wallet->increment('balance', $amount); 
            // Log the transaction
            Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'amount' => $amount,
                'reference' => $reference,
                'status' => $status,
                'description' => $reason,
                'transaction_type' => 'withdraw',
                'payment_method' => 'withdraw',
                'recipient_name' => $recipientName,
                'recipient_code' => $recipientCode,
                'account_number' => $accountNumber,
                'account_name' => $accountName,
                'bank_name' => $bankName,
            ]);

            // Trigger the notification
            $newBalance = $user->wallet->balance;
            $user->notify(new WalletTransferNotification($amount, $newBalance));

            Log::info("Wallet updated successfully for user: {$email}");
        } else {
            Log::warning("User with email {$email} not found.");
        }

    }

 


}

