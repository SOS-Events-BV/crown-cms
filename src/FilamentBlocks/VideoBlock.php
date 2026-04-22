<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Support\Icons\Heroicon;

class VideoBlock
{
    public static function make(): Block
    {
        return Block::make('video_block')
            ->label('Video (YouTube)')
            ->icon(Heroicon::VideoCamera)
            ->schema([
                TextInput::make('video_id')
                    ->label('Video ID')
                    ->afterLabel('Dit staat achter /watch?v={id}'),

                Flex::make([
                    Toggle::make('autoplay')
                        ->helperText('Video start automatisch')
                        ->default(false),

                    Toggle::make('controls')
                        ->helperText('Video kan worden bestuurd met knoppen')
                        ->default(true),

                    Toggle::make('mute')
                        ->helperText('Tijdens afspelen geen geluid')
                        ->default(false),
                ])
            ]);
    }
}
