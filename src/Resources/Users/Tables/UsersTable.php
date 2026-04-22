<?php

namespace SOSEventsBV\CrownCms\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('E-mailadres')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Rol'),

                IconColumn::make('is_active')
                    ->label('Account actief')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Gewijzigd op')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(
                // Exclude the current user from the query
                fn($query) => $query->where('id', '!=', Auth::user()->id)
            )
            ->filters([
                SelectFilter::make('role')
                    ->label('Rol')
                    ->native(false)
                    ->options(UserRole::class),

                Filter::make('is_active')
                    ->label('Toon alleen actieve gebruikers')
                    ->toggle()
                    ->query(fn($query) => $query->where('is_active', true)),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
