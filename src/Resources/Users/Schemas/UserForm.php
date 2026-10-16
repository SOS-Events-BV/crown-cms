<?php

namespace SOSEventsBV\CrownCms\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Naam')
                    ->required(),

                TextInput::make('email')
                    ->label('E-mailadres')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->label('Wachtwoord')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)) // Hash the password before saving
                    ->dehydrated(fn($state) => filled($state)) // Don't save the password if it's not being changed
                    ->required(fn(string $context): bool => $context === 'create'),

                Toggle::make('is_active')
                    ->inline(false)
                    ->label('Account actief')
                    ->default(true)
                    ->helperText('Indien uitgeschakeld, kan de gebruiker niet inloggen.'),

                Select::make('role')
                    ->label('Rol')
                    ->options(collect(config('crown-cms.roles'))->map(fn (array $role) => $role['label']))
                    ->required()
                    ->native(false),
            ]);
    }
}
