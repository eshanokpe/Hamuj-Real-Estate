<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MonnifyService
{
    private $baseUrl;
    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('monnify.base_url', env('MONNIFY_BASE_URL'));
        $this->apiKey = env('MONNIFY_API_KEY');
        $this->secretKey = env('MONNIFY_SECRET_KEY');
    }

    public function authenticate()
    {
        $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
            ->post("{$this->baseUrl}/api/v1/auth/login");

        if ($response->successful()) {
            return $response->json('responseBody.accessToken');
        }

        throw new \Exception('Authentication Failed: ' . $response->json('responseMessage'));
    }

    public function createCustomerWallet(array $data)
    {
        $accessToken = $this->authenticate();
        // $accessToken = 'TUtfVEVTVF9TQUY3SFI1RjNGOjRTWTZUTkw4Q0szVlBSU0JUSFRSRzJOOFhYRUdDNk5M';
        // dd($accessToken);

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/api/v1/disbursements/wallet", $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Wallet Creation Failed: ' . $response->json('responseMessage'));
    }
}
