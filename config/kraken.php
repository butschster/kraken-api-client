<?php

return [
    // API key
    'key' => env('KRAKEN_KEY'),

    // API Secret key
    'secret' => env('KRAKEN_SECRET'),

    // Two-factor password (if two-factor enabled, otherwise not required)
    'otp' => env('KRAKEN_OTP'),

    'minimal_volumes' => [
        'XREP' => 0.3,
        'XXBT' => 0.002,
        'BCH' => 0.002,
        'DASH' => 0.03,
        'DOGE' => 3000,
        'EOS' => 3,
        'XETH' => 0.2,
        'XETC' => 0.3,
        'GNO' => 0.03,
        'XICN' => 2,
        'XLTC' => 0.1,
        'XMLN' => 0.1,
        'XXMR' => 0.1,
        'XXRP' => 30,
        'XXLM' => 30,
        'XZEC' => 0.03,
        'USDT' => 5
    ]
];