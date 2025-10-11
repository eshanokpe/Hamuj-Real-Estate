<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet; // Import the Wallet model if not already done
use App\Notifications\WalletFundedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Jobs\ProcessOrderWebhook;
use App\Services\RevolutService;

 
class WebhookController extends Controller
{

    protected $revolutService;

    public function __construct(RevolutService $revolutService)
    {
        $this->revolutService = $revolutService;
    }

    public function handlePaystackWebhook(Request $request)
    {
        $paystackSecretKey = env('PAYSTACK_SECRET_KEY');
        $signature = $request->header('X-Paystack-Signature');
        $input = $request->getContent();

        // Verify signature
        if (!$signature || !hash_equals(hash_hmac('sha512', $input, $paystackSecretKey), $signature)) {
            Log::error('Invalid Paystack webhook signature.', ['signature' => $signature]);
            return response()->json(['error' => 'Unauthorized - Invalid Signature'], 401);
        }

        $event = json_decode($input);

        // Validate payload
        if (!$event || !isset($event->event) || !isset($event->data)) {
            Log::error('Invalid Paystack webhook payload.', ['payload' => $input]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        Log::info('Paystack Webhook Received', ['event' => $event->event, 'reference' => $event->data->reference ?? 'N/A']);

        // Route event to appropriate handler
        switch ($event->event) {
            case 'transfer.success':
                $this->handleTransferSuccess($event->data);
                break;
            case 'charge.success':
                $this->handleChargeSuccess($event->data);
                break;
             default:
                Log::info('Unhandled Paystack Event Type: ' . $event->event);
                break;
        }

        // Acknowledge receipt of the webhook
        return response()->json(['status' => 'success'], 200);
    }

    protected function handleChargeSuccess($data)
    {
        // Validate essential data presence
        if (!isset($data->reference) || !isset($data->customer->email) || !isset($data->amount) || !isset($data->status)) {
            Log::error('Missing essential data in charge.success payload.', (array) $data);
            return; 
        }

        $reference = $data->reference;
        $email = $data->customer->email;
        $amount = $data->amount / 100; 
        $status = $data->status; 

        Log::info("Processing charge.success for reference: {$reference}");

        // --- Idempotency Check ---
        DB::beginTransaction();
        try {
            $existingTransaction = Transaction::where('reference', $reference)
                                              ->where('transaction_type', 'wallet')
                                              ->lockForUpdate() 
                                              ->first();

            if ($existingTransaction) {
                Log::info("Duplicate charge.success event ignored for reference: {$reference}");
                DB::commit(); 
                return; 
            }

            // --- Process the charge ---
            // Check metadata for mobile app identifier if needed
            $isMobileApp = isset($data->metadata->source) && $data->metadata->source === 'mobile_app';
            if ($isMobileApp) {
                Log::info("Skipping mobile app payment processing via webhook for reference: {$reference}");
                DB::commit();
                return; 
            }

            // Find the user
            $user = User::where('email', $email)->first();
            if (!$user) {
                Log::warning("User not found for email: {$email}, reference: {$reference}");
                DB::rollBack();
                return; 
            }

            // Find or create user's wallet (handle case where wallet might not exist)
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0] 
            );

            // Update the wallet balance
            $wallet->increment('balance', $amount); 
 
            // Log the transaction in your database
            $customerName = ($data->customer->first_name ?? '') . ' ' . ($data->customer->last_name ?? '');
            Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'amount' => $amount, 
                'transaction_type' => 'wallet', 
                'reference' => $reference,
                'status' => $status, 
                'description' => 'Wallet funded via Paystack',
                'payment_method' => $data->channel ?? 'card', 
                'recipient_name' => trim($customerName) ?: null, 
                'source' => 'webhook', 
                'metadata' => json_encode($data->metadata ?? null), 
            ]);

            // Trigger the notification
            $newBalance = $wallet->fresh()->balance;
            $user->notify(new WalletFundedNotification($amount, $newBalance, $reference));

            Log::info("Wallet updated successfully for user: {$email}, reference: {$reference}. New balance: {$newBalance}");

            // Commit the transaction if everything was successful
            DB::commit();

        } catch (\Exception $e) {
            // Rollback transaction on any error
            DB::rollBack();
            Log::error("Error processing charge.success for reference: {$reference}. Error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString() 
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    } 

    protected function handleTransferSuccess($data)
    {
        // Validate essential data presence
        if (!isset($data->reference) || !isset($data->recipient->details->account_number) || !isset($data->amount) || !isset($data->status)) {
             Log::error('Missing essential data in transfer.success payload.', (array) $data);
             return;
        }

        $reference = $data->reference;
        $amount = $data->amount / 100; // Convert kobo to Naira
        $status = $data->status; 
        $reason = $data->reason ?? 'Withdrawal';
        $recipient = $data->recipient;

        Log::info("Processing transfer.success for reference: {$reference}");

        DB::beginTransaction();
        try {
            $existingTransaction = Transaction::where('reference', $reference)
                                              ->where('transaction_type', 'withdraw')
                                              ->lockForUpdate()
                                              ->first();

            if ($existingTransaction) {
                Log::info("Duplicate transfer.success event ignored for reference: {$reference}");
                DB::commit();
                return;
            }

            // --- Process the transfer ---
            $recipientName = $recipient->name ?? 'N/A';
            $recipientCode = $recipient->recipient_code ?? 'N/A';
            $accountNumber = $recipient->details->account_number ?? 'N/A';
            $accountName = $recipient->details->account_name ?? 'N/A';
            $bankName = $recipient->details->bank_name ?? 'N/A';

            $userId = $data->metadata->user_id ?? null; 
            $user = $userId ? User::find($userId) : null;

           
            if (!$user) {
                Log::warning("Could not determine user for transfer.success reference: {$reference}. Check metadata or internal records.");
                DB::rollBack();
                return; 
            }

            // Find the user's wallet
            $wallet = $user->wallet; 
            if (!$wallet) {
                    Log::error("Wallet not found for user ID: {$user->id}, reference: {$reference}. Cannot deduct amount.");
                    DB::rollBack();
                    return; 
            }

            // --- Deduct amount from user's wallet ---
            // Ensure sufficient balance before decrementing (optional but recommended)
            if ($wallet->balance < $amount) {
                Log::warning("Insufficient wallet balance for user ID: {$user->id}, reference: {$reference}. Balance: {$wallet->balance}, Amount: {$amount}");
                DB::rollBack();
                return;
            }
            $wallet->decrement('balance', $amount);
            Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email, 
                'amount' => -$amount, 
                'reference' => $reference,
                'status' => $status, 
                'description' => $reason,
                'transaction_type' => 'withdraw', 
                'payment_method' => 'bank_transfer', 
                'recipient_name' => $recipientName,
                'recipient_code' => $recipientCode,
                'account_number' => $accountNumber,
                'account_name' => $accountName,
                'bank_name' => $bankName,
                'source' => 'webhook', 
                'metadata' => json_encode($data->metadata ?? null),
            ]);

            Log::info("Withdrawal transaction logged successfully for user ID: {$user->id}, reference: {$reference}");

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error processing transfer.success for reference: {$reference}. Error: " . $e->getMessage(), [
                 'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function handleRevolutWebhook(Request $request)
    {
        $signature = $request->header('Revolut-Signature');
        $timestamp = $request->header('Revolut-Request-Timestamp');
        $payload = $request->getContent();
        // dd($payload);
  
        if (!$this->revolutService->validateTimestamp($timestamp)) {
            return response('Timestamp outside the tolerance zone', 403);
        }

        if (!$this->revolutService->validateSignature($signature, $timestamp, $payload)) {
            return response('Invalid signature', 403);
        }

        $event = $request->input('event');
        $orderData = $request->all();

        // Dispatch job to process the webhook asynchronously
        ProcessOrderWebhook::dispatch($event, $orderData); 

        return response()->json(['status' => 'success']);
    }
}


