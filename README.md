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

### Registering the plugin

Add the plugin to your Filament panel provider in `app/Providers/Filament/AdminPanelProvider.php`:

```php
use SOSEventsBV\CrownCms\CrownCmsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            CrownCmsPlugin::make(),
        ]);
}
```

### Redirecting

The CMS has a redirect feature built in. If you want to have redirects, you must add the following to your withMiddleware function in the `bootstap/app.php` file:
```php
use SOSEventsBV\CrownCms\Middleware\HandleRedirects;

return Application::configure(basePath: dirname(__DIR__))
    // ...
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(HandleRedirects::class);
    })
    // ...
```

### Environment variables

We also have a few environment variables that are required for the plugin to work. You need to fill this in with your own values and keys. Please add these to your `.env` file and `.env.example` file (but without the values 😉).

```dotenv
# LeisureKing API
CROWNCMS_LEISUREKING_API_URL="https://api.leisureking.eu/public"
CROWNCMS_LEISUREKING_API_VERSION="v4"
CROWNCMS_LEISUREKING_API_USERNAME=""
CROWNCMS_LEISUREKING_API_PASSWORD=""
CROWNCMS_LEISUREKING_API_ENVIRONMENT="test" # test or production
CROWNCMS_LEISUREKING_API_SHOPHID=""

# Weglot (is optional)
CROWNCMS_WEGLOT_API_KEY=""

# Reviews API
CROWNCMS_REVIEW_API_URL="https://reageren.sosevents.nl/api"
CROWNCMS_REVIEW_API_KEY=""
CROWNCMS_REVIEW_API_SHOP_ID=""

# Recaptcha / No captcha keys (no CROWNCMS_ prefix, is from the nocaptcha package)
NOCAPTCHA_SECRET=
NOCAPTCHA_SITEKEY=

# AI (optional) (from the laravel/ai package)
ANTHROPIC_API_KEY=
COHERE_API_KEY=
ELEVENLABS_API_KEY=
GEMINI_API_KEY=
MISTRAL_API_KEY=
OLLAMA_API_KEY=
OPENAI_API_KEY=
JINA_API_KEY=
VOYAGEAI_API_KEY=
XAI_API_KEY=
```

### Styling (optional)

The page view uses a `text-format` class for content formatting. Add the following to your CSS file:

```css
.text-format {
    @apply prose lg:prose-lg prose-headings:mb-4 prose-headings:not-first:mt-5 
    prose-headings:first:mt-0 max-w-none text-black;
}
```

Make sure you have the `@tailwindcss/typography` plugin installed.

_* This is not required, but this makes the page builder pages look a bit nicer._

## Requirements

This plugin requires a `layout` Blade component in your project with the following props:

```php
@props([
    'title' => config('app.name'),
    'description' => '',
    'keywords' => null,
    'og_title' => null,
    'og_description' => null,
    'og_image' => null,
])
```

If you are using the [Crown CMS Template](https://github.com/sos-events-bv/website-template), this is already included.

You can change the layout component in the config:

```php
'layout' => 'layout', // x-layout
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

Copyright (c) 2026 SOS Events BV. All rights reserved. Please see the [License File](LICENSE) for more information.

