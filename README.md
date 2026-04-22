# CMS Panel plugin for websites of SOS Events BV.

This package provides a CMS panel plugin for Filament for websites of SOS Events BV. This package contains a page builder, product resource, user management and more.

## Installation

After adding the package to your project, you can install the plugin by running:

```bash
php artisan crown-cms:install
```

This will ask if you want to run the migrations. If you haven't run the migrations yet, make sure you select yes. If you have already run the migrations, please delete all tables and run the migrations again.

Because we make changes to the User model, we need to add the `HasCrownCmsFields` trait to the User model. This can be done by adding the following line to the `App\Models\User` model:

```php
class User extends Authenticatable implements FilamentUser
{
    use HasCrownCmsFields; // There can be multiple traits, use a comma to separate them

    // ... The rest of the User model
}
```

## Usage

coming soon... :)

## Testing

```bash
composer test
```

## Credits

- [Steven Roest](https://github.com/stevenemr)
- [All Contributors](https://github.com/SOS-Events-BV/crown-cms/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
