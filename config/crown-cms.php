<?php

// config for SOSEventsBV/CrownCms
return [
    // Name of the app
    'app_name' => config('app.name', 'CrownCMS'),

    /**
     * Layout for the app
     */
    'layout' => 'layout',

    /**
     * Specify the models that should be used by the CrownCms plugin.
     */
    'models' => [
        'user' => \App\Models\User::class
    ],

    /**
     * Specify the routing settings for the CrownCms plugin.
     */
    'routing' => [
        'prefix' => '',
        'middleware' => ['web'],
    ],

    /**
     * All the services that are used by the CrownCms plugin.
     */
    'services' => [
        'leisureking' => [
            'url' => env('CROWNCMS_LEISUREKING_API_URL', 'https://api.leisureking.eu/public'),
            'version' => env('CROWNCMS_LEISUREKING_API_VERSION', 'v4'),
            'username' => env('CROWNCMS_LEISUREKING_API_USERNAME'),
            'password' => env('CROWNCMS_LEISUREKING_API_PASSWORD'),
            'environment' => env('CROWNCMS_LEISUREKING_API_ENVIRONMENT', 'test'),
            'shophid' => env('CROWNCMS_LEISUREKING_API_SHOPHID'),
        ],

        'weglot' => [
            'api_key' => env('CROWNCMS_WEGLOT_API_KEY'),
        ],

        'review' => [
            'url' => env('CROWNCMS_REVIEW_API_URL', 'https://reageren.sosevents.nl/api'),
            'api_key' => env('CROWNCMS_REVIEW_API_KEY'),
            'shop_id' => env('CROWNCMS_REVIEW_API_SHOP_ID'),
        ]
    ]
];
