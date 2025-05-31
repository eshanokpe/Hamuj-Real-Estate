<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'), 
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ], 
  
    'revolut' => [ 
        'secret_key' => env('REVOLUT_SECRET_KEY'),
        'public_key' => env('REVOLUT_PUBLIC_KEY'),
        'mode' => env('REVOLUT_MODE', 'sandbox'), // sandbox or production
        'sandbox_url' => 'https://sandbox-merchant.revolut.com',
        'production_url' => 'https://merchant.revolut.com',
        'webhook_secret' => env('REVOLUT_WEBHOOK_SECRET'), 
        'timeout' => env('REVOLUT_TIMEOUT', 30), // request timeout in seconds
    ],
    'exchange' => [
        'gbp_to_ngn' => env('EXCHANGE_RATE_GBP_TO_NGN', 1500), // Default rate if not set in .env
        'ngn_to_gbp' => function() {
            return 1 / config('services.exchange.gbp_to_ngn');
        }
    ],

];
