<?php

use Spatie\LaravelSettings\Exceptions\SettingAlreadyExists;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    /**
     * @throws SettingAlreadyExists
     */
    public function up(): void
    {
        $this->migrator->add('company.street', 'Straatnaam');
        $this->migrator->add('company.house_number', '1a');
        $this->migrator->add('company.zipcode', '1234AB');
        $this->migrator->add('company.city', 'Stad');
        $this->migrator->add('company.province', 'Gelderland');
        $this->migrator->add('company.country', 'Nederland');
        $this->migrator->add('company.email', 'info@voorbeeld.nl');
        $this->migrator->add('company.phone', '0123456789');
    }
};
