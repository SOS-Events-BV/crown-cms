<?php

namespace SOSEventsBV\CrownCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Pboivin\FilamentPeek\FilamentPeekPlugin;
use SOSEventsBV\CrownCms\Resources\Pages\PageResource;
use SOSEventsBV\CrownCms\Resources\Users\UserResource;

class CrownCmsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'crown-cms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->plugins([
                FilamentPeekPlugin::make(),
            ])
            ->resources([
                PageResource::class,
                UserResource::class
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
