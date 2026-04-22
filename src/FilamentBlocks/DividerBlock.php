<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class DividerBlock
{
    public static function make(): Block
    {
        return Block::make('divider_block')
            ->label('Divider')
            ->icon(Heroicon::Divide)
            ->schema([
                TextInput::make('px')->numeric()->suffix('px')->hiddenLabel(),
            ]);
    }
}
