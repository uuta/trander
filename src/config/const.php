<?php

return [
    'title_description' => env('TITLE_DESCRIPTION'),
    'meta_description' => env('META_DESCRIPTION'),
    'og_type' => env('OG_TYPE'),

    'security' => [
        'access_control_allow_origin' => env('ACCESS_CONTROL_ALLOW_ORIGIN'),
        'csrf_excerpt' => env('CSRF_EXCEPT'),
    ]
];
