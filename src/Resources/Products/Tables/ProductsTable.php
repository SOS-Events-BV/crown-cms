<?php

namespace SOSEventsBV\CrownCms\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Productnaam')
                    ->searchable(),

                TextColumn::make('euroPrices.amount')
                    ->label('Prijs/Prijzen (EUR)')
                    ->money('EUR')
                    ->sortable(),

                IconColumn::make('euroPrices.includes_vat')->boolean()->label('Incl. BTW'),

                ToggleColumn::make('is_active')->label('Actief'),

                TextColumn::make('created_at')->label('Aangemaakt op')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                // Filter for only active products
                Filter::make('is_active')->label('Enkel actieve producten')->query(function (Builder $query) {
                    return $query->where('is_active', true);
                })->toggle()
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
