<?php

namespace SOSEventsBV\CrownCms\Resources\Events;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SOSEventsBV\CrownCms\Models\Event;
use SOSEventsBV\CrownCms\Resources\Events\Pages\CreateEvent;
use SOSEventsBV\CrownCms\Resources\Events\Pages\EditEvent;
use SOSEventsBV\CrownCms\Resources\Events\Pages\ListEvents;
use SOSEventsBV\CrownCms\Resources\Events\Schemas\EventForm;
use SOSEventsBV\CrownCms\Resources\Events\Tables\EventsTable;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $recordTitleAttribute = 'name';

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Evenement';
    protected static ?string $pluralModelLabel = 'Evenementen';
    protected static ?string $navigationLabel = 'Evenementen';

    protected static string|\UnitEnum|null $navigationGroup = "Pagina's";

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
