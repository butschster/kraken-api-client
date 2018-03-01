<?php

return [
    // API key
    'key' => env('KRAKEN_KEY'),

    // API Secret key
    'secret' => env('KRAKEN_SECRET'),

    // Two-factor password (if two-factor enabled, otherwise not required)
    'otp' => env('KRAKEN_OTP'),
];