# CMS Panel plugin for websites of SOS Events BV.

This package provides a CMS panel plugin for Filament for websites of SOS Events BV. This package contains a page
builder, product resource, user management and more.

## Installation

After adding the package to your project, you can install the plugin by running:

```bash
php artisan crown-cms:install
```

This will ask if you want to run the migrations. If you haven't run the migrations yet, make sure you select yes. If you
have already run the migrations, please delete all tables and run the migrations again.

Because we make changes to the User model, we need to add the `HasCrownCmsFields` trait to the User model. This can be
done by adding the following line to the `App\Models\User` model:

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

The CMS has a redirect feature built in. If you want to have redirects, you must add the following to your
withMiddleware function in the `bootstrap/app.php` file:

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

We also have a few environment variables that are required for the plugin to work. You need to fill this in with your
own values and keys. Please add these to your `.env` file and `.env.example` file (but without the values 😉).

```dotenv
# LeisureKing API
CROWNCMS_LEISUREKING_API_URL="https://api.leisureking.eu/public"
CROWNCMS_LEISUREKING_API_VERSION="v4"
CROWNCMS_LEISUREKING_API_USERNAME=""
CROWNCMS_LEISUREKING_API_PASSWORD=""
CROWNCMS_LEISUREKING_API_ENVIRONMENT="test" # test or production
CROWNCMS_LEISUREKING_API_SHOPHID=""

# Reviews API
CROWNCMS_REVIEW_API_URL="https://reageren.sosevents.nl/api"
CROWNCMS_REVIEW_API_KEY=""
CROWNCMS_REVIEW_API_SHOP_ID=""

# Recaptcha / No captcha keys (no CROWNCMS_ prefix, is from the nocaptcha package)
NOCAPTCHA_SECRET=
NOCAPTCHA_SITEKEY=
```

### Styling (optional)

The page view uses a `text-format` class for content formatting. Add the following to your CSS file:

```css
.text-format {
    @apply prose prose-headings:mb-4 prose-headings:not-first:mt-5
    prose-h3:font-normal prose-h4:font-normal prose-h5:font-normal prose-h6:font-normal
    [&>*:first-child]:mt-0 [&>*:first-child]:pt-0
    [&>*:last-child]:mb-0 [&>*:last-child]:pb-0
    max-w-none text-black;
}
```

Make sure you have the `@tailwindcss/typography` plugin installed.

_* This is not required, but this makes the page builder pages look a bit nicer. You can change things if you want
different styling._

Also make sure that you add the following to your `app.css` file:

```css
@source '../../vendor/sos-events-bv/crown-cms/**/*.{blade.php,php}';
```

This will make sure that the CSS of the page builder blocks is included in the build.

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

### Optional features

By default the plugin registers all resources. You can disable individual features when registering the plugin:

```php
CrownCmsPlugin::make()
    ->withoutReviews()
    ->withoutFaq()
    ->withoutEvents()
    ->withoutProducts(), // also disables Categories
```

### Page builder

Pages are built in the admin panel using a block-based editor. Each page's content is stored as a JSON array of typed
blocks. On the front end, the page view loops over `$page->content_objects` and renders each block as a Blade component:

```blade
@foreach ($page->content_objects as $block)
    <x-dynamic-component :component="'crown-cms::blocks.' . $block->type" :data="$block->data" />
@endforeach
```

The entire loop is wrapped in a `<div class="text-format">`, so your `text-format` CSS class applies to all block
output.

> **Do not use these components in your own views.** These blocks are specially made for the pagebuilder and
> will not work in 'normal' blade views.

### Using the page builder on your own models

If you want to use the page builder on a model other than `Page` (e.g. `Product`), add the `HasContentBlocks` trait:

```php
use SOSEventsBV\CrownCms\Traits\HasContentBlocks;

class Product extends Model
{
    use HasContentBlocks;

    protected $casts = ['content' => 'array'];
}
```

Then use `ContentBuilder::make('content')->blocks(ContentBuilder::blocks('product'))` in your Filament form schema, and
render with `$product->content_objects` in your Blade view.

If the content field is named differently, override `contentBlocksField()` in your model:

```php
protected function contentBlocksField(): string
{
    return 'description';
}
```

### Form builder

Pages with a `FormBuilderBlock` get a form at `/{slug}/submit`. On successful submission the visitor is redirected to
`/{slug}/success`. The block stores the recipient email address and the success title/message — no additional
configuration is needed.

### Routes config

The `routes` array in `config/crown-cms.php` maps resource types to named routes in your application. These are used to
show a "View on site" button in the admin panel. Set a value to `null` to hide the button for that resource.

```php
'routes' => [
    'page'     => 'page',      // route('page', $slug)
    'category' => 'category',  // route('category', $slug)
    'product'  => 'product',   // route('product', $slug)
    'reviews'  => 'reviews',
    'faq'      => 'faq',
    'events'   => 'events',
    'products' => 'products',
],
```

### Overriding views

Publish the config and point `views.page` to your own Blade view to customise the page layout:

```php
'views' => [
    'page' => 'my-theme::page.show',
],
```

## Credits

- [Steven Roest](https://github.com/stevenemr)
- [All Contributors](https://github.com/SOS-Events-BV/crown-cms/contributors)

## License

Copyright © 2026 SOS Events BV. All rights reserved. Please see the [License File](LICENSE) for more information.

