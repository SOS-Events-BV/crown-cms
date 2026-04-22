<?php

namespace SOSEventsBV\CrownCms\Resources\Redirects\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use SOSEventsBV\CrownCms\Resources\Redirects\RedirectResource;

class ManageRedirects extends ManageRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
