<?php

return [
    'api_key' => env('SPF_API_KEY'),
    'secret_key' => env('SPF_SECRET_KEY'),
    'scopes' => [
        'read_products',
        'read_customers',
        'read_orders',
        'read_content'
    ],
    'redirect_uri' => env('SPF_REDIRECT_URI')
];
