<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'payout_key' => env('MIDTRANS_PAYOUT_KEY'),
    'payout_url' => env('MIDTRANS_PAYOUT_URL'),
    'approve_key' => env('MIDTRANS_APPROVE_KEY'),

    'is_production' => env('APP_ENV') == 'production',
    'is_sanitized' => true,
    'is_3ds' => true,
];
