<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class FaqBlock
{
    public static function make(): Block
    {
        return Block::make('faq_block')
            ->label('FAQ blok')
            ->icon(Heroicon::QuestionMarkCircle)
            ->schema([
                Repeater::make('faqs')
                    ->label('FAQ\'s')
                    ->addActionLabel('FAQ toevoegen')
                    ->collapsible()
                    ->schema([
                        TextInput::make('question')->label('Vraag'),
                        RichEditor::make('answer')->label('Antwoord')
                    ])
            ]);
    }
}
