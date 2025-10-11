<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RevolutService
{
    protected $client;
    protected $apiUrl;
    protected $secretKey;
    protected $webhookSecret;

    public function __construct()
    {
        $this->apiUrl = config('services.revolut.sandbox_url'); 
        $this->secretKey = config('services.revolut.secret_key');
        $this->webhookSecret = config('services.revolut.webhook_secret');
        $this->client = new Client();
    }

    public function createOrder($amount, $currency, $description)
    {
        return $this->client->post("{$this->apiUrl}/api/1.0/orders", [
            'headers' => [
                'Authorization' => "Bearer {$this->secretKey}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
            ]
        ]);
    }

    public function getOrder($orderId)
    {
        return $this->client->get("{$this->apiUrl}/api/1.0/orders/{$orderId}", [
            'headers' => [
                'Authorization' => "Bearer {$this->secretKey}",
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function validateTimestamp($timestamp)
    {
        $tolerance = 5 * 60; // 5 minutes in seconds
        $currentTime = time();
        return abs($currentTime - $timestamp) <= $tolerance;
    }

    public function validateSignature($signature, $timestamp, $payload)
    {
        $signatureVersion = substr($signature, 0, strpos($signature, '='));
        $payloadToSign = "{$signatureVersion}.{$timestamp}.{$payload}";
        $expectedSignature = hash_hmac('sha256', $payloadToSign, $this->webhookSecret);
        
        return hash_equals($signature, "{$signatureVersion}={$expectedSignature}");
    }
}