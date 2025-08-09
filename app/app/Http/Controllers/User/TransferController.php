<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\VirtualAccount;
use Illuminate\Http\Request;
use App\Services\PaystackService;
use Illuminate\Support\Facades\Http;

class TransferController extends Controller
{
      
    public function initiateTransfer(Request $request, PaystackService $paystackService)
    { 
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'account_number' => 'required|string|max:50|exists:virtual_accounts,account_number',
            'reason' => 'nullable|string|max:255',
        ]); 

        $amountInKobo = $validated['amount'] * 100; // Convert to kobo for NGN
        $accountNumber = $validated['account_number'];
        $reason = $validated['reason'] ?? "Transfer";
        $customer_code = VirtualAccount::where('account_number',$accountNumber)->first();
        $customerCode = $customer_code->customer_code;

        $response = $paystackService->initiateTransfer($amountInKobo, $customerCode, $reason);

        if ($response['status']) {
            return response()->json([
                'status' => true,
                'message' => 'Transfer initiated successfully',
                'data' => $response['data'],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => $response['message'],
        ], 400);
    } 

   

}
