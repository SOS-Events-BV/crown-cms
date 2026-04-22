<?php

// config for SOSEventsBV/CrownCms
return [
    'app_name' => config('app.name', 'CrownCMS'),

    /**
     * Layout for the app
     */
    'layout' => 'layouts.app',

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
    ]
];
