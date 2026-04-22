<?php
// These are the routes of the CMS package
// These are catch-all routes, meaning these must always be last; otherwise it may
// replace links that already exists.
// DON'T CHANGE THE ORDER OF THE ROUTES!

use SOSEventsBV\CrownCms\Http\Controllers\PageController;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::prefix(config('crown-cms.routing.prefix', ''))
    ->middleware(config('crown-cms.routing.middleware', ['web']))
    ->group(function () {
        Route::post('/{slug}/submit', [PageController::class, 'submitForm'])
            ->where('slug', '.+')
            ->name('page.submit')
            ->middleware([ProtectAgainstSpam::class, 'throttle:5,2']); // Honeypot and throttle (max 5 submissions per 2 minutes).

        Route::get('/{slug}/success', [PageController::class, 'showSuccess'])
            ->where('slug', '.+')
            ->name('page.success');

        Route::get('/{slug}', [PageController::class, 'show'])
            ->where('slug', '.+')
            ->name('page');
    });
