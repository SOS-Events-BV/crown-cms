<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Support\Icons\Heroicon;

class ContentBlock
{
    public static function make(): Block
    {
        return Block::make('content_block')
            ->label('Content blok')
            ->icon(Heroicon::DocumentText)
            ->schema([
                RichEditor::make('content')
                    ->hiddenLabel()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h1', 'h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'bulletList', 'orderedList'],
                        ['table'],
                        ['undo', 'redo'],
                    ])
                    ->required(),
            ]);
    }
}
