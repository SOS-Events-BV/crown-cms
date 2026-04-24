<?php

namespace SOSEventsBV\CrownCms\Resources\Events\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\CrownCms\Resources\Events\EventResource;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Button to events page
            Action::make('showEventsPage')
                ->label('Toon evenementen pagina')
                ->icon(Heroicon::Users)
                ->url(config('crown-cms.routes.events') ? route(config('crown-cms.routes.events')) : null)
                ->hidden(!config('crown-cms.routes.events'))
                ->color('gray')
                ->openUrlInNewTab(),

            CreateAction::make(),
        ];
    }
}
