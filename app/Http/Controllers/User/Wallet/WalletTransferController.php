<?php

namespace App\Http\Controllers\User\Wallet;
use Auth;
use Log;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\WalletController  as PayStackWalletController;
use Illuminate\Support\Facades\Http;
use App\Services\TransferService;

class WalletTransferController extends Controller
{
    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function createRecipient(Request $request)
    {  
        $user = Auth::user();
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->post('https://api.paystack.co/transferrecipient', [
            'type' => 'nuban', // Nigerian bank account
            'name' => $request->name,
            'account_number' => $request->account_number,
            'bank_code' => $request->bank_code, 
            'currency' => 'NGN',
            'email' => $user->email,
        ]);

        $data = $response->json();
    
        if ($response->successful()) {
            return response()->json([
                'status' => 'success', 
                'recipient_code' => $data['data']['recipient_code']
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => $data['message']]);
        }
    }

    public function initiateTransfer(Request $request)
    {
        $validated = $request->validate([
            'recipient_code' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string',
            'accountName' => 'nullable|string',
            'bankName' => 'nullable|string',
        ]);

        $user = Auth::user();
        $userWallet = $user->wallet;
        
        if ($userWallet->balance < (float)$validated['amount']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient wallet balance.',
            ], 400);
        } 
        
        $transferResponse = $this->processTransfer($validated); 
        if ($transferResponse['status'] === 'success') {
            
            $transferAmount = ($transferResponse['data']['amount'] ?? 0) / 100;

            if ($userWallet->balance >= $transferAmount) {
                $userWallet->balance -= $transferAmount;
                $userWallet->save();

                // Log the transaction
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'wallet_id' => $userWallet->id,
                    'type' => 'transfer',
                    'accountName' => $validated['accountName'],
                    'bankName' => $validated['bankName'],
                    'amount' => $transferAmount,
                    'recipient_code' => $validated['recipient_code'],
                    'reason' => $validated['reason'],
                    'status' => 'success',
                    'metadata' => $transferResponse, // Store the Paystack response
                ]);

                Log::info('Transfer successful. Wallet updated.');
                return response()->json(['status' => 'success', 'data' => $transferResponse['data']]);
            } else {
                Log::error('Wallet balance mismatch after transfer.');
                return response()->json(['status' => 'error', 'message' => 'Insufficient wallet balance.'], 400);
            }
        } else {
            WalletTransaction::create([
                'user_id' => $user->id,
                'wallet_id' => $userWallet->id,
                'type' => 'transfer',
                'accountName' => $validated['accountName'],
                'bankName' => $validated['bankName'],
                'amount' => (float)$validated['amount'],
                'recipient_code' => $validated['recipient_code'],
                'reason' => $validated['reason'],
                'status' => 'failed',
                'metadata' => $transferResponse, // Store the Paystack response
            ]);
            Log::error('Transfer failed. Paystack response:', $transferResponse);
            return response()->json(['status' => 'error', 'message' => $transferResponse['message']]);
        }
       
    }

    public function processTransfer(array $validated)
    {
        $user = Auth::user();
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->post('https://api.paystack.co/transfer', [
            'source' => 'balance',
            'amount' => $validated['amount'] * 100, // Amount in kobo
            'recipient' => $validated['recipient_code'],
            'reason' => $validated['reason'],
            'email' => $user->email,
        ]);

        $data = $response->json();

        if ($response->successful()) {
            return ['status' => 'success', 'data' => $data['data']];
        } else {
            return ['status' => 'error', 'message' => $data['message']];
        }

    }

    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'transfer_code' => 'required|string',
            'otp' => 'required|string',
        ]);

        $response = $this->transferService->verifyOtp($validated['transfer_code'], $validated['otp']);

        if ($response['status'] === 'success') {
           
            $userWallet = Auth::user()->wallet;
            $transferAmount = $response['data']['amount'] ?? 0;
            $userWallet->balance -= $transferAmount;
            $userWallet->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Transfer completed successfully.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $response['message'] ?? 'Failed to verify OTP.',
        ], 400);
    }

    protected function calculateTransferFee($amount)
    {
        return $amount >= 500000 ? 2500 : 1000; // Fee in kobo (₦25 or ₦10)
    }

    // $fee = $this->calculateTransferFee($validated['amount']);
    // $totalAmount = $validated['amount'] + $fee;

    // if ($userWallet->balance < $totalAmount) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Insufficient wallet balance to cover transfer and fees.',
    //     ], 400);
    // }

    public function getWalletTransactions(Request $request)
    {
        $user = $request->user();
        $transactions = $user->walletTransactions()->latest()->get();

        return response()->json($transactions);
    }

   
}
