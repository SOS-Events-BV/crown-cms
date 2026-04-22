<?php

namespace SOSEventsBV\CrownCms\Resources\Reviews\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Review Info')
                    ->description('Informatie van de review, zoals aantal sterren, wanneer het geplaatst is en of het zichtbaar moet zijn.')
                    ->columnSpanFull()
                    ->aside()
                    ->columns(2)
                    ->schema([
                        // When the user placed the review
                        TextEntry::make('review_placed')
                            ->label('Review geplaatst')
                            ->icon(Heroicon::Clock)
                            ->dateTime(),

                        // When the review was placed on the website
                        TextEntry::make('created_at')
                            ->label('Toegevoegd op site')
                            ->icon(Heroicon::Plus)
                            ->dateTime(),

                        TextEntry::make('stars')
                            ->label('Aantal sterren')
                            ->icon(Heroicon::Star),

                        Toggle::make('is_visible')
                            ->label('Is zichtbaar')
                            ->inline(false),

                        // Link to LeisureKing reservation
                        TextEntry::make('reservation_hash')
                            ->icon(Heroicon::Link)
                            ->color('primary')
                            ->url(fn($record) => "https://oms.leisureking.eu/reservering?h={$record->reservation_hash}") // URL that will be opened
                            ->openUrlInNewTab()
                            ->label('LeisureKing reservatie hash'),

                        // Extra attributes field in the table
                        KeyValueEntry::make('extra_attributes')
                            ->label('Extra attributen'),
                    ]),

                TextInput::make('firstname')->label('Voornaam'),
                TextInput::make('lastname')->label('Achternaam'),
                Textarea::make('review')->autosize()->label('Review'),
                Textarea::make('reaction')->autosize()->label('Reactie'),
            ]);
    }
}
