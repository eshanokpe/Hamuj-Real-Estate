<?php

namespace App\Services;

use GuzzleHttp\Client;

class FaceTecService
{
    protected $client; 
    protected $baseUrl = 'https://api.facetec.com/api/v3.1/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Device-Key' => config('services.facetec.device_key'),
                'X-User-Agent' => 'YourApp/1.0 Laravel/' . app()->version()
            ]
        ]);
    }

    public function createSession($userId)
    {
        $response = $this->client->post('sessions', [
            'json' => [
                'externalDatabaseRefID' => $userId,
                'livenessCheck' => 'high'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function verifySession($sessionId, $faceScan, $auditTrailImage)
    {
        $response = $this->client->post('sessions/' . $sessionId . '/verify', [
            'json' => [
                'faceScan' => $faceScan,
                'auditTrailImage' => $auditTrailImage,
                'livenessCheck' => 'high'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}