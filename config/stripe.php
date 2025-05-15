<?php

return [
    'stripe_sk' => env('STRIPE_SECRET'),
    'stripe_ws' => env('STRIPE_WEBHOOK_SECRET'),
    'currency' => 'huf',
    'mode' => 'payment',
    'default_status' => 'pending',
    'succeeded_status' => 'succeeded',
    'failed_status' => 'failed',
];
