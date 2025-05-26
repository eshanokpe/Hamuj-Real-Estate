<?php

return [ 
    'base_url' => env('OPAY_BASE_URL', 'https://testapi.opaycheckout.com'), // Opay API endpoint
    'merchant_id' => env('OPAY_MERCHANT_ID'),
    'public_key' => env('OPAY_PUBLIC_KEY'),
    'private_key' => env('OPAY_PRIVATE_KEY'),
    'currency' => env('OPAY_CURRENCY', 'NGN'),
    'callback_url' => env('OPAY_CALLBACK_URL'), // Your endpoint to handle payment notifications
];
 
 