<?php

namespace SOSEventsBV\CrownCms\Resources\Categories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use SOSEventsBV\CrownCms\FilamentComponents\SeoSettings;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('SEO Instellingen')
                    ->description('Beheer de SEO instellingen voor deze categorie.')
                    ->aside()
                    ->schema([
                        SeoSettings::make('category/og'),

                        Grid::make(2)->schema(array_filter([
                            config('crown-cms.routes.category') ?
                                // Clickable URL to the page
                                TextEntry::make('url')
                                    ->hiddenOn('create')
                                    ->label('Bekijk categoriepagina')
                                    ->state('Klik hier')
                                    ->url(fn($record) => route(config('crown-cms.routes.category'), $record->slug)) // URL that will be opened
                                    ->icon(Heroicon::Link)
                                    ->color('primary')
                                    ->openUrlInNewTab() // Open the URL in a new tab
                                : null,

                            // Toggle for active status
                            Toggle::make('is_active')
                                ->label('Categoriepagina actief')
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

                TextInput::make('name')
                    ->label('Naam')
                    ->required(),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),

                RichEditor::make('description')
                    ->label('Beschrijving')
                    ->required()
                    ->columnSpanFull(),

                Select::make('products')
                    ->label('Producten')
                    ->helperText('Selecteer de producten die bij deze categorie horen')
                    ->relationship('products', 'name')
                    ->multiple()
                    ->preload(),

                Repeater::make('example_time_schemes')
                    ->label('Voorbeeld Tijdschema\'s')
                    ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                    ->schema([
                        TextInput::make('name')
                            ->label('Naam programma')
                            ->placeholder('bijv. Ochtendprogramma')
                            ->required(),

                        Repeater::make('rows')
                            ->label('Onderdelen')
                            ->grid(2)
                            ->schema([
                                Grid::make(2)->schema([
                                    TimePicker::make('start_time')
                                        ->label('Van')
                                        ->required(),
                                    TimePicker::make('end_time')
                                        ->label('Tot')
                                        ->required(),
                                ]),
                                TextInput::make('activity')
                                    ->label('Activiteit')
                                    ->placeholder('Ontvangst met koffie')
                                    ->required(),
                            ])
                            ->addActionLabel('Onderdeel toevoegen'),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel('Nieuw tijdschema toevoegen'),

                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Afbeeldingen')
                    ->collection('category')
                    ->disk('public')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->reorderable()
                    ->appendFiles()
                    ->panelLayout('grid')
                    ->getUploadedFileNameForStorageUsing(
                    // UUID-based, unique file name with original title + hash and extension
                        fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                            . '_' . Str::uuid()
                            . '.' . $file->getClientOriginalExtension()
                    )
                    ->columnSpanFull(),
            ]);
    }
}
