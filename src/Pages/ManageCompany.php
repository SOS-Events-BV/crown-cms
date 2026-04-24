<?php

namespace SOSEventsBV\CrownCms\Pages;

use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Settings\CompanySettings;

class ManageCompany extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string $settings = CompanySettings::class;

    protected static ?string $title = 'Bedrijfsinformatie';

    protected static string|\UnitEnum|null $navigationGroup = "Instellingen";

    protected static ?int $navigationSort = 3;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('street')
                    ->label('Straatnaam')
                    ->required(),

                TextInput::make('house_number')
                    ->label('Huisnummer')
                    ->required(),

                TextInput::make('zipcode')
                    ->label('Postcode')
                    ->required(),

                TextInput::make('city')
                    ->label('Stad')
                    ->required(),

                TextInput::make('province')
                    ->label('Provincie')
                    ->required(),

                TextInput::make('country')
                    ->label('Land')
                    ->required(),

                TextInput::make('email')
                    ->label('E-mailadres')
                    ->email()
                    ->required(),

                TextInput::make('phone')
                    ->label('Telefoonnummer')
                    ->tel()
                    ->required(),
            ]);
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
