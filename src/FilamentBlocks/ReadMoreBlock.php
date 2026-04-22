<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Support\Icons\Heroicon;

class ReadMoreBlock
{
    public static function make(): Block
    {
        return Block::make('read_more_block')
            ->label('Lees meer')
            ->icon(Heroicon::BookOpen)
            ->schema([
                RichEditor::make('content_1')
                    ->label('Inhoud 1')
                    ->helperText('Deze inhoud wordt altijd weergegeven.'),

                RichEditor::make('content_2')
                    ->label('Inhoud 2')
                    ->helperText('Deze inhoud wordt weergegeven als je op de \'Meer lezen\' knop klikt.'),
            ]);
    }
}
