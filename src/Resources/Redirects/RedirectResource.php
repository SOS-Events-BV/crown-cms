<?php


namespace SOSEventsBV\CrownCms\Resources\Redirects;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use SOSEventsBV\CrownCms\Models\Redirect;
use SOSEventsBV\CrownCms\Resources\Redirects\Pages\ManageRedirects;
use UnitEnum;


class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowsRightLeft;

    protected static string|UnitEnum|null $navigationGroup = "Instellingen";

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('from')
                    ->label('Van URL')
                    ->required()
                    ->prefix(config('app.url') . '/')
                    ->placeholder('Bijvoorbeeld oude-pagina of oud/pagina')
                    ->helperText('Zet geen / aan het begin, mag wel een / bevatten (Bijvoorbeeld: pagina/subpagina).')
                    ->dehydrateStateUsing(fn($state) => ltrim($state, '/')) // Removes slash if the user types it
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                TextInput::make('to')
                    ->required()
                    ->placeholder('Bijvoorbeeld /nieuwe-pagina of https://google.com')
                    ->helperText('Gebruik een / voor interne pagina\'s, type https:// voor externe pagina\'s (Bijvoorbeeld https://google.com).')
                    ->dehydrateStateUsing(function ($state) {
                        if (empty($state)) return $state;

                        // If the user types in a full URL, just return it.
                        if (str_starts_with($state, 'http')) {
                            return $state;
                        }

                        // If the user types in a relative URL, add a / to the beginning.
                        return str_starts_with($state, '/') ? $state : "/{$state}";
                    })
                    ->columnSpanFull(),

                Select::make('status_code')
                    ->options([
                        301 => '301 (Permanent)',
                        302 => '302 (Tijdelijk)',
                    ])
                    ->default(301)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from')
                    ->label('Van URL')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('to')
                    ->label('Naar URL')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status_code')
                    ->colors([
                        'success' => 301,
                        'warning' => 302,
                    ])
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status_code')
                    ->label('Status code')
                    ->options([
                        301 => '301 (Permanent)',
                        302 => '302 (Tijdelijk)',
                    ])
                    ->native(false),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageRedirects::route('/'),
        ];
    }
}
