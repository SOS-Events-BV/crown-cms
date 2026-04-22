<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use SOSEventsBV\CrownCms\FilamentComponents\ContentBuilder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;

class TwoColumnBlock
{
    public static function make(string $directory = 'page'): Block
    {
        return Block::make('two_column_block')
            ->label('Twee kolommen')
            ->icon(Heroicon::ViewColumns)
            ->columns(2)
            ->schema([
                Group::make()
                    ->columns(3)
                    ->schema([
                        Select::make('layout_ratio')
                            ->label('Layout ratio')
                            ->helperText('Bepaalt de verhouding tussen de linker- en rechterkolom op grotere schermen.')
                            ->options([
                                '50_50' => '50 / 50 (Helft / Helft)',
                                '33_66' => '33 / 66 (Eén derde / Twee derde)',
                                '66_33' => '66 / 33 (Twee derde / Eén derde)',
                                '25_75' => '25 / 75 (Kwart / Driekwart)',
                                '75_25' => '75 / 25 (Driekwart / Kwart)',
                            ])
                            ->default('50_50'),

                        ColorPicker::make('background_color')
                            ->label('Achtergrondkleur')
                            ->helperText('Kies een achtergrondkleur voor de twee kolommen. (optioneel)')
                            ->nullable(),

                        ColorPicker::make('text_color')
                            ->label('Tekstkleur')
                            ->helperText('Kies een tekstkleur voor de twee kolommen. (optioneel)')
                            ->nullable(),

                        Toggle::make('center_content')
                            ->inline(false)
                            ->default(false)
                            ->label('Centreren inhoud')
                            ->helperText('Hiermee kan je de inhoud centreren in de linker- en rechterkolom.'),
                    ])->columnSpanFull(),


                Builder::make('left_column')
                    ->label('Linker kolom')
                    ->blocks(ContentBuilder::columnBlocks($directory))
                    ->blockIcons()
                    ->blockPickerColumns(2)
                    ->reorderableWithButtons(),

                Builder::make('right_column')
                    ->label('Rechter kolom')
                    ->blocks(ContentBuilder::columnBlocks($directory))
                    ->blockIcons()
                    ->blockPickerColumns(2)
                    ->reorderableWithButtons(),
            ]);
    }
}
