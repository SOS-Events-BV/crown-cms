<?php

namespace SOSEventsBV\CrownCms\Settings;

use Spatie\LaravelSettings\Settings;

class CompanySettings extends Settings
{
    public string $street = '';
    public string $house_number = '';
    public string $zipcode = '';
    public string $city = '';
    public string $province = 'Gelderland';
    public string $country = 'Nederland';
    public string $email = '';
    public string $phone = '';

    public static function group(): string
    {
        return 'company';
    }
}
