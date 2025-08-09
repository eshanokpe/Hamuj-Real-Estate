<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TransferService
{
    protected $apiBaseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiBaseUrl = env('PAYSTACK_BASE_URL');
        $this->apiKey = env('PAYSTACK_SECRET_KEY');
    }

    public function verifyOtp(string $transferCode, string $otp): array
    {
        try {
            // Make the API call to verify the OTP
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiBaseUrl}/transfer/verify", [
                'transfer_code' => $transferCode,
                'otp' => $otp,
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                return [
                    'status' => 'success',
                    'message' => $response->json('message'),
                    'data' => $response->json('data'),
                ];
            }

            // Handle errors from the API
            return [
                'status' => 'error',
                'message' => $response->json('message') ?? 'OTP verification failed.',
            ];
        } catch (\Exception $e) {
            // Handle any exceptions
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
