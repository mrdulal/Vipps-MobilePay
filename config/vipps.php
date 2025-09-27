<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vipps Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the environment for Vipps API calls.
    | Supported: "test", "production"
    |
    */
    'environment' => env('VIPPS_ENVIRONMENT', 'test'),

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | Your Vipps API credentials obtained from the Vipps Developer Portal.
    | These are required for all API operations.
    |
    */
    'client_id' => env('VIPPS_CLIENT_ID'),
    'client_secret' => env('VIPPS_CLIENT_SECRET'),
    'subscription_key' => env('VIPPS_SUBSCRIPTION_KEY'),
    'merchant_serial_number' => env('VIPPS_MERCHANT_SERIAL_NUMBER'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | Base URLs for different Vipps API environments.
    |
    */
    'api_endpoints' => [
        'test' => [
            'base_url' => 'https://apitest.vipps.no',
            'ecom_url' => 'https://apitest.vipps.no/ecomm/v2',
            'checkout_url' => 'https://apitest.vipps.no/checkout/v3',
            'recurring_url' => 'https://apitest.vipps.no/recurring/v3',
            'order_management_url' => 'https://apitest.vipps.no/order-management/v1',
        ],
        'production' => [
            'base_url' => 'https://api.vipps.no',
            'ecom_url' => 'https://api.vipps.no/ecomm/v2',
            'checkout_url' => 'https://api.vipps.no/checkout/v3',
            'recurring_url' => 'https://api.vipps.no/recurring/v3',
            'order_management_url' => 'https://api.vipps.no/order-management/v1',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the HTTP client used to make API requests.
    |
    */
    'http' => [
        'timeout' => 30,
        'connect_timeout' => 10,
        'verify' => true,
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for handling Vipps webhooks.
    |
    */
    'webhook' => [
        'secret' => env('VIPPS_WEBHOOK_SECRET'),
        'tolerance' => 300, // 5 minutes
        'verify_signature' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Payment Configuration
    |--------------------------------------------------------------------------
    |
    | Default values for payment requests.
    |
    */
    'defaults' => [
        'currency' => 'NOK',
        'country' => 'NO',
        'language' => 'no',
        'skip_landing_page' => false,
        'user_flow' => 'WEB_REDIRECT',
    ],

    /*
    |--------------------------------------------------------------------------
    | Recurring Payment Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration specific to recurring payments.
    |
    */
    'recurring' => [
        'default_interval' => 'MONTH',
        'default_interval_count' => 1,
        'max_amount' => 200000, // 2000.00 NOK in øre
        'default_currency' => 'NOK',
    ],

    /*
    |--------------------------------------------------------------------------
    | Express Checkout Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for express checkout functionality.
    |
    */
    'express' => [
        'enabled' => true,
        'button_theme' => 'orange', // orange, white, white-outline
        'button_size' => 'large', // small, medium, large
        'show_on_cart' => true,
        'show_on_product' => true,
        'show_on_category' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for logging Vipps API interactions.
    |
    */
    'logging' => [
        'enabled' => env('VIPPS_LOGGING_ENABLED', false),
        'channel' => env('VIPPS_LOG_CHANNEL', 'default'),
        'level' => env('VIPPS_LOG_LEVEL', 'info'),
        'log_requests' => true,
        'log_responses' => true,
        'log_headers' => false, // Set to false to avoid logging sensitive headers
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for caching access tokens and other data.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
        'prefix' => 'vipps_',
        'store' => null, // Use default cache store
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for error handling and retry logic.
    |
    */
    'error_handling' => [
        'retry_attempts' => 3,
        'retry_delay' => 1000, // milliseconds
        'throw_on_error' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific features.
    |
    */
    'features' => [
        'epayment' => true,
        'checkout' => true,
        'express' => true,
        'recurring' => true,
        'order_management' => true,
        'webhooks' => true,
    ],
];