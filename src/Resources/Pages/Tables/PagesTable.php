<?php

namespace SOSEventsBV\CrownCms\Resources\Pages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('seo.page_title')->label('Titel'),

                TextColumn::make('slug')
                    ->label('Pagina')
                    ->url(fn($record) => route('page', $record->slug))
                    ->icon(Heroicon::Link)
                    ->color('primary')
                    ->openUrlInNewTab(),

                ToggleColumn::make('is_active')->label('Actief'),

                TextColumn::make('created_at')->dateTime()->label('Aangemaakt op')->sortable(),
            ])
            ->filters([
                // Filter for only active pages
                Filter::make('is_active')->label('Enkel actieve pagina\'s')->query(function (Builder $query) {
                    return $query->where('is_active', true);
                })->toggle()
            ])
            ->recordActions([
                EditAction::make(),

                // Add a DeleteAction with a custom modal heading and description
                DeleteAction::make()
                    ->modalHeading('Pagina verwijderen')
                    ->modalDescription('Weet je zeker dat je deze pagina permanent wilt verwijderen? De slug van deze pagina wordt vrijgegeven. Als je bestaande links wilt opvangen, stel dan eerst een redirect in via het kopje Redirects.')
                    ->successNotification(Notification::make()
                        ->warning()
                        ->title('Pagina verwijderd')
                        ->body('Vergeet niet een redirect in te stellen om bestaande links op te vangen.')
                        ->persistent()
                        ->actions([
                            Action::make('createRedirect')
                                ->label('Redirect aanmaken')
                                ->button()
                                ->url(route('filament.admin.resources.redirects.index'))
                        ])
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
