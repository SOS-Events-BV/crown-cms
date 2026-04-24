<?php

namespace SOSEventsBV\CrownCms\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use SOSEventsBV\CrownCms\FilamentComponents\SeoSettings;
use SOSEventsBV\CrownCms\FilamentComponents\ContentBuilder;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('SEO Instellingen')
                    ->description('Beheer de SEO instellingen voor deze pagina.')
                    ->aside()
                    ->schema([
                        // SEO Settings component
                        SeoSettings::make('page/og'),

                        Grid::make(2)->schema(array_filter([
                            config('crown-cms.routes.page') ?
                                // Clickable URL to the page
                                TextEntry::make('url')
                                    ->hiddenOn('create')
                                    ->label('Bekijk pagina')
                                    ->state('Klik hier')
                                    ->url(fn($record) => route(config('crown-cms.routes.page'), $record->slug)) // URL that will be opened
                                    ->icon(Heroicon::Link)
                                    ->color('primary')
                                    ->openUrlInNewTab() // Open the URL in a new tab
                                : null,

                            // Toggle for active status
                            Toggle::make('is_active')
                                ->label('Pagina actief')
                                ->inline(false)
                                ->default(true),
                        ])),

                        // Created by and updated by with timestamps
                        Grid::make(2)->hiddenOn('create')->schema([
                            TextEntry::make('created_at')
                                ->label('Aangemaakt op')
                                ->dateTime('d-m-Y H:i')
                                ->color('gray'),

                            TextEntry::make('updated_at')
                                ->label('Gewijzigd op')
                                ->dateTime('d-m-Y H:i')
                                ->color('gray'),
                        ]),
                    ])->columnSpanFull(),

                // Unique slug to the page
                TextInput::make('slug')
                    ->label('Pagina slug')
                    ->afterLabel('Zoals `pagina` of `subpagina/pagina`')
                    ->required()
                    ->unique(ignorable: fn($record) => $record)
                    ->columnSpanFull(),

                // Page Builder
                ContentBuilder::make('content'),
            ]);
    }
}
