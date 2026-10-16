<?php

namespace SOSEventsBV\CrownCms\Traits;

use Filament\Facades\Filament;

trait HasCrownCmsPagePermissions
{
    public static function canAccess(): bool
    {
        return Filament::auth()->user()?->hasPermission(static::class, 'manage') ?? false;
    }
}
