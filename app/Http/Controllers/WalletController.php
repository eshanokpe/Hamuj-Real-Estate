<?php

namespace App\Http\Controllers;
use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{ 
    public function getWalletBalance($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return User::find($userId)->wallet_balance;
    }
    
    // Create Customer  
    public function createVirtualAccountCustomer($user)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post(env('PAYSTACK_BASE_URL') . '/customer', [
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' =>  $user->phone,
            ]);
 
            if ($response->successful()) {
                return $response->json()['data']['customer_code'] ?? null;
            }

            return null;  
    }

    // Create Dedicated Virtual Account
    

    public function createDedicatedAccount(string $customerId)
    {
        $data = ['customer' => $customerId];
        // $data['preferred_bank'] = 'wema-bank';
        $data['preferred_bank'] = 'titan-paystack';
        // $data['preferred_bank'] = 'test-bank';
            
        try {
            $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
                ->post(env('PAYSTACK_BASE_URL') . '/dedicated_account', $data);

            if ($response->successful()) {
                return $response->json(); 
            }
 
            return null; 
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Exception during Paystack Dedicated Account Creation', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
     
            return null; 
        }
    }

    public function createTransferRecipient()
    {
        $url = "https://api.paystack.co/transferrecipient";
        $fields = [
            "type" => "nuban",
            "name" => "Tolu Robert",
            "account_number" => "1238237021",
            "bank_code" => "120001",
            "currency" => "NGN"
        ];
        // Send POST request using Laravel HTTP client
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Cache-Control' => 'no-cache',
        ])
        ->post($url, $fields);
        // Get the response body
        $result = $response->body();
        // Return the result or handle the response as needed
        return $result;
    }

    public function getBanks()
    {
        $url = "https://api.paystack.co/bank";
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Cache-Control' => 'no-cache',
            ])->get($url);

            if ($response->failed() || !$response->json('data')) {
                return []; // Return an empty array if the request fails
            }
            // Get the response body
            return $response->json('data');
        } catch (\Exception $e) {
            // return $response->json('data');
            Log::error('Error fetching banks from Paystack', ['message' => $e->getMessage()]);
            return [];
        }
    }
    public function verifyAccount($accountNumber, $bankCode)
    {
        
        $url = "https://api.paystack.co/bank/resolve";
        $url = "https://api.paystack.co/bank/resolve";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
        ])->get($url, [
            'account_number' => $accountNumber,
            'bank_code' => $bankCode,
        ]);

        if ($response->failed() || !$response->json('status')) {
            return response()->json(['error' => 'Unable to verify account'], 400);
        }

        return response()->json([
            'account_name' => $response->json('data.account_name'),
        ]);
    }

    

}
