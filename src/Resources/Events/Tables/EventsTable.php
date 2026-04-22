<?php

namespace SOSEventsBV\CrownCms\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Start datum')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Eind datum')
                    ->dateTime()
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Actief'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
