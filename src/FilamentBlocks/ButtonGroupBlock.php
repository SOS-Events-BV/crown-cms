<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;

class ButtonGroupBlock
{
    public static function make(): Block
    {
        return Block::make('button_group_block')
            ->label('Knop(pen) / link(s)')
            ->icon(Heroicon::CursorArrowRays)
            ->schema([
                Repeater::make('buttons')
                    ->hiddenLabel()
                    ->schema([
                        // Add different types of buttons here
                        // 3 defaults are added in the template by default. If you have another button here, add this one to this file.
                        Select::make('class')
                            ->label('Knop type')
                            ->options([
                                // full CSS class name of button => name to show in Filament
                                'btn btn-blue' => 'Blauw',
                                'btn btn-pink' => 'Roze',
                                'btn' => 'Grijs'
                            ])->required(),

                        TextInput::make('content')->label('Knop tekst')->required(),

                        TextInput::make('url')->required(),

                        Toggle::make('open_in_new_tab')
                            ->label('Openen in nieuwe tab')
                            ->required()
                            ->inline(false),
                    ])->columns(2)
            ]);
    }
}
