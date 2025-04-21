<?php

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet; // Import the Wallet model if not already done
use App\Notifications\WalletFundedNotification;
use App\Notifications\WalletTransferNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 


class WebhookController extends Controller
{


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
            return; // Stop processing if critical data is missing
        }

        $reference = $data->reference;
        $email = $data->customer->email;
        $amount = $data->amount / 100; // Convert kobo to Naira/base currency unit
        $status = $data->status; // Should be 'success'

        Log::info("Processing charge.success for reference: {$reference}");

        // --- Idempotency Check ---
        // Use a database transaction with locking for atomicity
        DB::beginTransaction();
        try {
            // Check if this transaction reference has already been processed
            $existingTransaction = Transaction::where('reference', $reference)
                                              ->where('transaction_type', 'wallet') // Be specific if reference could be used elsewhere
                                              ->lockForUpdate() // Lock the row to prevent race conditions
                                              ->first();

            if ($existingTransaction) {
                Log::info("Duplicate charge.success event ignored for reference: {$reference}");
                DB::commit(); // Commit transaction even if duplicate
                return; // Exit early, already processed
            }

            // --- Process the charge ---

            // Check metadata for mobile app identifier if needed
            $isMobileApp = isset($data->metadata->source) && $data->metadata->source === 'mobile_app';
            if ($isMobileApp) {
                Log::info("Skipping mobile app payment processing via webhook for reference: {$reference}");
                DB::commit(); // Commit transaction
                return; // Exit if handled elsewhere for mobile
            }

            // Find the user
            $user = User::where('email', $email)->first();
            if (!$user) {
                Log::warning("User not found for email: {$email}, reference: {$reference}");
                DB::rollBack(); // Rollback transaction
                return; // Cannot process without a user
            }

            // Find or create user's wallet (handle case where wallet might not exist)
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0] // Initialize balance if creating new wallet
            );

            // Update the wallet balance
            $wallet->increment('balance', $amount);

            // Log the transaction in your database
            $customerName = ($data->customer->first_name ?? '') . ' ' . ($data->customer->last_name ?? '');
            Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'amount' => $amount, // Store the actual amount credited
                'transaction_type' => 'wallet', // Specific type for wallet funding
                'reference' => $reference,
                'status' => $status, // 'success'
                'description' => 'Wallet funded via Paystack',
                'payment_method' => $data->channel ?? 'card', // Get channel if available
                'recipient_name' => trim($customerName) ?: null, // Store customer name if available
                'source' => 'webhook', // Indicate source is webhook
                'metadata' => json_encode($data->metadata ?? null), // Store metadata if needed
            ]);

            // Trigger the notification
            // Fetch the updated balance directly after incrementing
            $newBalance = $wallet->fresh()->balance;
            $user->notify(new WalletFundedNotification($amount, $newBalance, $reference));

            Log::info("Wallet updated successfully for user: {$email}, reference: {$reference}. New balance: {$newBalance}");

            // Commit the transaction if everything was successful
            DB::commit();

        } catch (\Exception $e) {
            // Rollback transaction on any error
            DB::rollBack();
            Log::error("Error processing charge.success for reference: {$reference}. Error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString() // Log stack trace for debugging
            ]);
            // Optionally re-throw or handle the error appropriately
            // Depending on your setup, you might want Paystack to retry, so don't return 200 OK here.
            // Consider returning a 5xx error to signal failure.
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    protected function handleTransferSuccess($data)
    {
        // Validate essential data presence
        if (!isset($data->reference) || !isset($data->recipient->details->account_number) || !isset($data->amount) || !isset($data->status)) {
             Log::error('Missing essential data in transfer.success payload.', (array) $data);
             return; // Stop processing if critical data is missing
        }

        $reference = $data->reference;
        $amount = $data->amount / 100; // Convert kobo to Naira
        $status = $data->status; // Should be 'success'
        $reason = $data->reason ?? 'Withdrawal';
        $recipient = $data->recipient;

        Log::info("Processing transfer.success for reference: {$reference}");

        // --- Idempotency Check ---
        DB::beginTransaction();
        try {
            // Check if this transfer reference has already been processed
            $existingTransaction = Transaction::where('reference', $reference)
                                              ->where('transaction_type', 'withdraw') // Be specific
                                              ->lockForUpdate()
                                              ->first();

            if ($existingTransaction) {
                Log::info("Duplicate transfer.success event ignored for reference: {$reference}");
                DB::commit();
                return; // Exit early, already processed
            }

            // --- Process the transfer ---

            // Extract recipient details safely
            $recipientName = $recipient->name ?? 'N/A';
            $recipientCode = $recipient->recipient_code ?? 'N/A';
            $accountNumber = $recipient->details->account_number ?? 'N/A';
            $accountName = $recipient->details->account_name ?? 'N/A';
            $bankName = $recipient->details->bank_name ?? 'N/A';

            // Find the user associated with this transfer.
            // Paystack transfer webhooks don't directly link to your initiating user via email in the main data.
            // You might need to:
            // 1. Store the user_id in the Paystack transfer metadata when initiating.
            // 2. Query your *internal* transfer records using the reference to find the user.
            // **Assuming you stored user_id in metadata:**
            $userId = $data->metadata->user_id ?? null; // Adjust based on your metadata key
            $user = $userId ? User::find($userId) : null;

            // **Alternative: Query internal records (Example)**
            // $internalTransferRecord = YourTransferModel::where('paystack_reference', $reference)->first();
            // $user = $internalTransferRecord ? $internalTransferRecord->user : null;

            if (!$user) {
                Log::warning("Could not determine user for transfer.success reference: {$reference}. Check metadata or internal records.");
                DB::rollBack();
                return; // Cannot process without user context
            }

            // Find the user's wallet
            $wallet = $user->wallet; // Assumes a 'wallet' relationship exists on the User model
            if (!$wallet) {
                    Log::error("Wallet not found for user ID: {$user->id}, reference: {$reference}. Cannot deduct amount.");
                    DB::rollBack();
                    return; // Cannot process without a wallet
            }

            // --- Deduct amount from user's wallet ---
            // Ensure sufficient balance before decrementing (optional but recommended)
            if ($wallet->balance < $amount) {
                Log::warning("Insufficient wallet balance for user ID: {$user->id}, reference: {$reference}. Balance: {$wallet->balance}, Amount: {$amount}");
                // Decide how to handle: Log and proceed? Rollback?
                // Rolling back might be safer if the transfer shouldn't have been possible.
                DB::rollBack();
                return;
            }
            $wallet->decrement('balance', $amount);
            // -----------------------------------------


            // Log the withdrawal transaction
            // Note: Wallet balance should have been *debited* when the transfer was *initiated*,
            // not credited here on success. This webhook confirms the external transfer completed.
            Transaction::create([
                'user_id' => $user->id,
                'email' => $user->email, // Log user's email
                'amount' => -$amount, // Represent withdrawal as negative or use a 'type' field
                'reference' => $reference,
                'status' => $status, // 'success'
                'description' => $reason,
                'transaction_type' => 'withdraw', // Specific type
                'payment_method' => 'bank_transfer', // Method used
                'recipient_name' => $recipientName,
                'recipient_code' => $recipientCode,
                'account_number' => $accountNumber,
                'account_name' => $accountName,
                'bank_name' => $bankName,
                'source' => 'webhook', // Indicate source
                'metadata' => json_encode($data->metadata ?? null),
            ]);

            // Trigger notification (optional, maybe notify on initiation or here)
            // $user->notify(new WalletTransferNotification($amount, $user->wallet->balance)); // Consider if balance is needed here

            Log::info("Withdrawal transaction logged successfully for user ID: {$user->id}, reference: {$reference}");

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error processing transfer.success for reference: {$reference}. Error: " . $e->getMessage(), [
                 'trace' => $e->getTraceAsString()
            ]);
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}


