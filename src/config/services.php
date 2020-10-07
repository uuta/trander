<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    "twitter" => [
        "client_id" => env("TWITTER_CLIENT_ID"),
        "client_secret" => env("TWITTER_CLIENT_SECRET"),
        "redirect" => env("TWITTER_CALLBACK_URL"),
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect'      => env('FACEBOOK_CALLBACK_URL')
    ],

    'google' => [
        'client_id'     => env('GOOGLE_APP_ID'),
        'client_secret' => env('GOOGLE_APP_SECRET'),
        'redirect'      => env('GOOGLE_CALLBACK_URL')
    ],

    'yahoo_local_search' => [
        'app_id'        => env('YAHOO_LOCAL_SEARCH'),
    ],

    'rakuten_hotel_search' => [
        'app_id'        => env('RAKUTEN_HOTEL_SEARCH'),
        'affiliate_id'        => env('RAKUTEN_AFFILIATE_ID'),
    ],

    'open_weather_map' => [
        'app_id'        => env('OPEN_WEATHER_MAP'),
    ],

    'google_places' => [
        'key'     => env('GOOGLE_PLACES'),
    ],
];
