<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class LeisureKingFrame
{
    public static function make(): Block
    {
        return Block::make('leisureking_frame')
            ->label('LeisureKing iFrame')
            ->icon(Heroicon::ComputerDesktop)
            ->schema([
                TextInput::make('bookingmodule_code')
                    ->prefix('https://booking.leisureking.eu/bm/')
                    ->label('Boekingsmodule code')
                    ->required()
                    ->maxLength(255),

                Section::make('Instellingen')
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        Toggle::make('no_scroll')
                            ->inline(false)
                            ->default(true)
                            ->helperText('Schakel in om niet direct te scrollen naar het iFrame (optioneel, standaard: aan).'),

                        DatePicker::make('date')
                            ->label('Datum')
                            ->helperText("Datum waarop geboekt moet worden (optioneel).")
                            ->default(null),

                        DatePicker::make('min_date')
                            ->label('Minimale datum')
                            ->helperText("Startdatum in de datum selectie (optioneel).")
                            ->default(null),

                        DatePicker::make('max_date')
                            ->label('Maximale datum')
                            ->helperText("Einddatum in de datum selectie (optioneel).")
                            ->default(null),

                        Select::make('lang')
                            ->label('Taal')
                            ->helperText('Taal van de boekingsmodule (optioneel).')
                            ->options([
                                'NL' => 'Nederlands',
                                'EN' => 'Engels',
                                'DE' => 'Duits',
                                'FR' => 'Frans',
                                'ES' => 'Spaans',
                                'PT' => 'Portugees',
                            ])
                            ->default(null),
                    ])
            ]);
    }
}
