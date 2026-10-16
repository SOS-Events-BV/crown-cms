<?php

namespace SOSEventsBV\CrownCms\Traits;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\Response;
use UnitEnum;

trait HasCrownCmsPermissions
{
    public static function getAuthorizationResponse(string|UnitEnum $action, ?Model $record = null): Response
    {
        $action = $action instanceof UnitEnum ? $action->name : $action;

        $permission = match ($action) {
            'viewAny', 'view' => 'view',
            'create', 'replicate' => 'create',
            'update', 'reorder' => 'update',
            default => 'delete',
        };

        if (! Filament::auth()->user()?->hasPermission(static::class, $permission)) {
            return Response::deny();
        }

        return parent::getAuthorizationResponse($action, $record);
    }
}
