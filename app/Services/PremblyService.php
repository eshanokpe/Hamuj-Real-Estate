<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PremblyService
{
    protected $baseUrl;
    protected $apiKey;
    protected $sandboxMode;
    protected $bvnValidationPath;

    public function __construct()
    {
        $this->baseUrl = config('services.prembly.base_url');
        $this->apiKey = config('services.prembly.api_key');
        $this->sandboxMode = config('services.prembly.sandbox_mode');
        $this->bvnValidationPath = config('services.prembly.bvn_validation_path');
    }

    public function verifyBvn($bvn, $firstName = null, $lastName = null)
    {
        // return [
        //     'status' => false,
        //     'baseUrl' => $this->baseUrl,
        //     'apiKey' => $this->apiKey,
        //     'bvn' => $bvn,
        //     'firstName' => $firstName,
        //     'lastName' => $lastName,
        // ];
        if (empty($this->baseUrl)) {
            throw new \Exception('Prembly base URL is not configured.');
        }
        
        $url = $this->baseUrl .'/identitypass/verification/bvn_validation';
        
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/x-www-form-urlencoded',
            'x-api-key' => $this->apiKey,
        ])->post($url, [
            'number' => $bvn
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Verify names if provided
            if ($firstName && $lastName && isset($data['data'])) {
                $bvnFirstName = strtolower($data['data']['firstName'] ?? '');
                $bvnLastName = strtolower($data['data']['lastName'] ?? '');
                $inputFirstName = strtolower($firstName);
                $inputLastName = strtolower($lastName);

                if ($bvnFirstName !== $inputFirstName || $bvnLastName !== $inputLastName) {
                    return [
                        'status' => false,
                        'message' => 'Names do not match BVN records'
                    ];
                }
            }

            return $data;
        }

        return [
            'status' => false,
            'message' => 'BVN verification failed',
            'response_code' => $response->status()
        ];
    }
}