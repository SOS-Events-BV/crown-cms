<?php

namespace SOSEventsBV\CrownCms\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
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

                        Grid::make(2)->schema([
                            TextEntry::make('url')
                                ->hiddenOn('create')
                                ->label('Bekijk pagina')
                                ->state('Klik hier')
                                ->url(fn (Get $get, $record) => $get('is_active') && config('crown-cms.routes.page') ? route(config('crown-cms.routes.page'), $record->slug) : null)
                                ->icon(Heroicon::Link)
                                ->color(fn (Get $get) => $get('is_active') ? 'primary' : 'gray')
                                ->openUrlInNewTab(),

                            // Toggle for active status
                            Toggle::make('is_active')
                                ->label('Pagina actief')
                                ->inline(false)
                                ->default(true)
                                ->live(),
                        ]),

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
                    ->helperText(
                        fn ($record, Get $get) => $get('slug') ?
                            'Dit wordt de URL van deze pagina: ' . route(config('crown-cms.routes.page'), $get('slug'))
                        : null
                    )
                    ->live(debounce: 500)
                    ->columnSpanFull(),

                // Page Builder
                ContentBuilder::make('content'),
            ]);
    }
}
