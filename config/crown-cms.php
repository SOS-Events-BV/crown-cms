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
        'weglot' => [
            'api_key' => env('WEGLOT_API_KEY'),
        ]
    ]
];
