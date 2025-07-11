<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        Log::debug('createVirtualAccountCustomer', [
            'user' => $user,
        ]);

        $phone = preg_replace('/[^0-9]/', '', $user->phone);

        if (Str::startsWith($phone, '0')) {
            $phone = '234' . substr($phone, 1);
        }

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post(env('PAYSTACK_BASE_URL') . '/customer', [
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $phone,
            ]);

        Log::debug('phoneCustomer', ['phone' => $phone]);

        if ($response->successful()) {
            $customer = $response->json('data');

            // Ensure phone is set correctly in Paystack
            if (empty($customer['phone'])) {
                $this->updateCustomerPhone($customer['customer_code'], $phone);
                $customer['phone'] = $phone;
            }

            return $customer; // return full customer object
        }

        Log::error('Failed to create customer', [
            'status' => $response->status(),
            'response' => $response->body()
        ]);

        return null;
    }

    // ✅ Update Paystack customer with phone
    public function updateCustomerPhone(string $customerCode, string $phone)
    {
        Log::debug('Updating Paystack Customer Phone', [
            'customer_code' => $customerCode,
            'phone' => $phone
        ]);

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->put(env('PAYSTACK_BASE_URL') . '/customer/' . $customerCode, [
                'phone' => $phone,
            ]);

        Log::debug('Paystack Update Response', [
            'status' => $response->status(),
            'body' => $response->json()
        ]);

        return $response->successful();
    }

    // ✅ Create Dedicated Virtual Account using customer_code
    public function createDedicatedAccount(string $customerCode)
    {
        $data = [
            'customer' => $customerCode,
            'preferred_bank' => 'titan-paystack',
        ];

        Log::debug('Creating Dedicated Account for Customer', [
            'customerId' => $customerCode,
            'payload' => $data
        ]);

        try {
            $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
                ->post(env('PAYSTACK_BASE_URL') . '/dedicated_account', $data);

            Log::debug('Paystack Response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::error('Paystack API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $responseData = $response->json();

            if (!isset($responseData['status']) || !$responseData['status'] || !isset($responseData['data'])) {
                Log::error('Invalid or Unexpected Paystack Response', $responseData);
                return null;
            }

            return $responseData['data']; // Return just the data section
        } catch (\Exception $e) {
            Log::error('Exception while creating Dedicated Account', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Cache-Control' => 'no-cache',
        ])
        ->post($url, $fields);

        return $response->body();
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
                return [];
            }

            return $response->json('data');
        } catch (\Exception $e) {
            Log::error('Error fetching banks from Paystack', ['message' => $e->getMessage()]);
            return [];
        }
    }

    public function verifyAccount($accountNumber, $bankCode)
    {
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
