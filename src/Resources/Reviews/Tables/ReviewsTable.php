<?php

namespace SOSEventsBV\CrownCms\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Volledige naam')
                    ->searchable(),

                TextColumn::make('stars')
                    ->label('Aantal sterren')
                    ->sortable(),

                TextColumn::make('review')
                    ->limit(30),

                IconColumn::make('reaction')
                    ->label('Heeft reactie')
                    ->boolean()
                    ->state(fn($record): bool => !empty($record->reaction)),

                ToggleColumn::make('is_visible')
                    ->label('Is zichtbaar'),

                TextColumn::make('review_placed')
                    ->label('Review geplaatst')
                    ->sortable()
                    ->dateTime(),
            ])
            ->defaultSort('review_placed', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->authorize(fn ($record) => Auth::user()->getRole() === UserRole::Admin),
                ]),
            ]);
    }
}
