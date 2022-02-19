<?php

return [
    'title_description' => env('TITLE_DESCRIPTION'),
    'meta_description' => env('META_DESCRIPTION'),
    'og_type' => env('OG_TYPE'),

    'security' => [
        'access_control_allow_origin' => env('ACCESS_CONTROL_ALLOW_ORIGIN'),
        'csrf_excerpt' => env('CSRF_EXCEPT'),
    ],

    'auth0' => [
        'domain' => env('AUTH0_DOMAIN', ''),
        'client_id' => env('AUTH0_CLIENT_ID', ''),
        'client_secret' => env('AUTH0_CLIENT_SECRET', ''),
        'test_id_token' => env('AUTH0_TEST_ID_TOKEN', ''),
    ],

    'geo_db_cities' => [
        'api_key' => env('GEO_DB_CITIES_API', '')
    ],

    'test' => [
        'email' => env('TEST_EMAIL', ''),
    ]
];
