<?php

namespace SOSEventsBV\CrownCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
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
            ->resources([
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
