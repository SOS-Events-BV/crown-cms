<?php

namespace SOSEventsBV\CrownCms\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Pagina')
                    ->url(fn($record) => config('crown-cms.routes.category') ?
                        route(config('crown-cms.routes.category'), $record->slug) :
                        null
                    ) // URL that will be opened
                    ->icon(config('crown-cms.routes.category') ? Heroicon::Link : null)
                    ->color(config('crown-cms.routes.category') ? 'primary' : null)
                    ->openUrlInNewTab(), // Open the URL in a new tab,

                ToggleColumn::make('is_active')
                    ->label('Actief')
                    ->inline(false),
            ])
            ->filters([
                // Filter for only active categories
                Filter::make('is_active')->label('Enkel actieve categorieën')->query(function (Builder $query) {
                    return $query->where('is_active', true);
                })->toggle()
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
