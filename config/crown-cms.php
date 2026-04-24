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
     * Specify the views that should be used by the CrownCms plugin.
     * Override these to use your own views with custom styling.
     */
    'views' => [
        'page' => 'crown-cms::page.show',
    ],

    /**
     * Specify the models that should be used by the CrownCms plugin.
     */
    'models' => [
        'user' => \App\Models\User::class
    ],

    /**
     * Specify the routing settings for the Page model. These will be used for the Page model.
     */
    'routing' => [
        'prefix' => '',
        'middleware' => ['web'],
    ],

    /**
     * Specify the routes that should be used by the CrownCms plugin. Use the `name` of the route to link to it.
     * If the route is null, the show button is not shown.
     */
    'routes' => [
        // Need `slug` parameter
        'page' => 'page', // Don't change this unless you know what you're doing. This is the default page route.
        'category' => null, // The overview page for a category with associated products
        'product' => null, // The detail page for a single product

        // No `slug` parameter
        'reviews' => null, // The page with all reviews
        'faq' => null, // The page with all FAQ questions
        'events' => null, // The overview page for all events
        'products' => null, // The overview page for all products
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
