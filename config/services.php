<?php

return [
    'owm' => [
        'key' => env('OWM_API_KEY'),
    ],
    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
    ],
    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],
];
