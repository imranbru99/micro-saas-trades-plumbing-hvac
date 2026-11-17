<?php

return [
    'brand' => 'TradeFlow',
    'product' => 'Micro-SaaS for Plumbing, HVAC & Trades',
    'accent' => '#0F172A',
    'demo' => [
        'email' => env('DEMO_USER_EMAIL', 'demo@tradeflow.test'),
        'password' => env('DEMO_USER_PASSWORD', 'password'),
    ],
    'trade_types' => [
        'plumbing' => 'Plumbing',
        'hvac' => 'HVAC',
        'electrical' => 'Electrical',
        'drain' => 'Drain Cleaning',
        'multi' => 'Multi-Trade',
    ],
];
