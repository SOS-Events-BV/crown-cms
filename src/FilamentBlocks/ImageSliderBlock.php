<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageSliderBlock
{
    /**
     * Creates the configuration for an image slider block.
     *
     * @param string $directory The directory where images will be stored. Defaults to 'page/slider'.
     * @return Block The configured image slider block instance.
     */
    public static function make(string $directory = 'page/slider'): Block
    {
        return Block::make('image_slider_block')
            ->label('Afbeelding slider')
            ->icon(Heroicon::Photo)
            ->schema([
                Repeater::make('images')
                    ->label('Afbeeldingen')
                    ->schema([
                        FileUpload::make('url')
                            ->label('Afbeelding')
                            ->disk('public')
                            ->directory($directory . '/slider')
                            ->image()
                            ->imageEditor()
                            ->getUploadedFileNameForStorageUsing(
                            // UUID-based, unique file name with original title + hash and extension
                                fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                    . '_' . Str::uuid()
                                    . '.' . $file->getClientOriginalExtension()
                            )
                            ->required(),

                        TextInput::make('alt')
                            ->label('Alt'),
                    ])
                    ->grid(2)
                    ->addActionLabel('Toevoegen aan slider'),

                Section::make('Instellingen')
                    ->collapsed()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Toggle::make('loop')
                                    ->label('Loop')
                                    ->default(false),

                                Toggle::make('navigation')
                                    ->label('Navigatie pijlen')
                                    ->default(false),

                                Toggle::make('pagination')
                                    ->label('Pagination')
                                    ->default(false),

                                Toggle::make('autoplay')
                                    ->label('Autoplay')
                                    ->default(false)
                                    ->live(),
                            ]),

                        TextInput::make('autoplay_speed')
                            ->label('Autoplay snelheid (ms)')
                            ->numeric()
                            ->default(3000)
                            ->minValue(500)
                            ->suffix('ms')
                            ->visible(fn($get) => $get('autoplay')),

                        Section::make('Slides per breakpoint')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('slides_mobile')
                                            ->label('Mobiel (< 640px)')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1),
                                        TextInput::make('slides_tablet')
                                            ->label('Tablet (640px)')
                                            ->numeric()
                                            ->default(2)
                                            ->minValue(1),
                                        TextInput::make('slides_desktop')
                                            ->label('Desktop (1024px)')
                                            ->numeric()
                                            ->default(3)
                                            ->minValue(1),
                                    ]),
                            ]),

                        TextInput::make('space_between')
                            ->label('Afstand tussen slides (px)')
                            ->suffix('px')
                            ->numeric()
                            ->default(20),
                    ]),
            ]);
    }
}
