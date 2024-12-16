<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected $baseUrl;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = env('PAYSTACK_BASE_URL');
        $this->secretKey = env('PAYSTACK_SECRET_KEY');
    }
    
    public function getBalance(){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
        ])->get( env('PAYSTACK_BASE_URL').'/balance');

        if ($response->successful()) {
            $balance = $response->json()['data'][0]['balance'];
            return $balance;
        }
        return 'Error fetching balance: ' . $response->body();
    }

    public function initiateTransfer($amount, $customerCode, $reason, $currency = "NGN", $reference = null)
    {
        $balance = $this->getBalance();
        // dd($balance);
        $data = [
            // "source" => $balance,
            "source" => 'balance',
            "amount" => $amount, // Amount in kobo for NGN
            "recipient" => $customerCode,
            "reason" => $reason,
            "currency" => $currency,
        ];

        // if ($reference) {
        //     $data['reference'] = $reference;
        // }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post(env('PAYSTACK_BASE_URL').'/transfer', $data);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'status' => false,
            'message' => $response->json('message') ?? 'Transfer initiation failed',
        ];
    }

    
}
