<?php

namespace SOSEventsBV\CrownCms\Resources\Users;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Resources\Users\Pages\CreateUser;
use SOSEventsBV\CrownCms\Resources\Users\Pages\EditUser;
use SOSEventsBV\CrownCms\Resources\Users\Pages\ListUsers;
use SOSEventsBV\CrownCms\Resources\Users\Schemas\UserForm;
use SOSEventsBV\CrownCms\Resources\Users\Tables\UsersTable;

class UserResource extends Resource
{
    protected static ?string $model = null;

    public static function getModel(): string
    {
        return config('crown-cms.models.user');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = "Instellingen";

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Gebruiker';
    protected static ?string $pluralModelLabel = 'Gebruikers';
    protected static ?string $navigationLabel = 'Gebruikers';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    /**
     * Can only be accessed by admins.
     *
     * @return bool
     */
    public static function canAccess(): bool
    {
        return Auth::user()->getRole() === UserRole::Admin;
    }
}
