<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
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
    

    public function createDedicatedAccount(string $customerId, string $preferredBank = 'test-bank')
    {
        $data = ['customer' => $customerId];

        if ($preferredBank) {
            $data['preferred_bank'] = $preferredBank;
        }

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post(env('PAYSTACK_BASE_URL') . '/dedicated_account', $data);

        if ($response->successful()) {
            return $response->json(); // Return the response data
        }

        return null; // Return null if unsuccessful
    }


}
