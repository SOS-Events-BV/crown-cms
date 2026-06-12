# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
composer lint          # Auto-fix code style with PHP Pint
composer test:lint     # Check code style without modifying files
```

## What This Is

`crown-cms` is a **Laravel Filament plugin package** (`sos-events-bv/crown-cms`) that provides a full CMS panel for SOS Events BV websites. It is not a standalone app — it is installed into a host Laravel app via Composer and registered in that app's Filament panel provider.

The plugin ships with a page builder, product/category management, events, FAQ, reviews, user management, redirects, and company settings. Features can be toggled off at registration time via `CrownCmsPlugin::make()->withoutReviews()->withoutEvents()` etc.

## Architecture

### Plugin Entry Points

- `src/CrownCmsPlugin.php` — implements `Filament\Contracts\Plugin`; registers resources, pages, and navigation groups into the panel. Optional feature flags (`$withReviews`, `$withFaq`, `$withEvents`, `$withProducts`) control which resources are registered.
- `src/CrownCmsServiceProvider.php` — extends Spatie's `PackageServiceProvider`; publishes config, migrations, views, and translations. Routes are loaded inside `app->booted()` so the catch-all page routes are always last.

### Filament Resources (`src/Resources/`)

Each resource follows the Filament v5 split-file convention: `XResource.php` at the top level with subdirectories `Pages/`, `Schemas/`, and `Tables/` holding the form schema, table columns, and CRUD page classes respectively.

Resources: `Pages`, `Users`, `Categories`, `Products`, `Events`, `FaqPageQuestions`, `Reviews`, `Redirects`.

### Page Builder

The page builder is the core feature. It uses Filament's `Builder` component to compose a JSON array of typed blocks, stored in a `content` column (cast to `array`).

- `src/FilamentBlocks/` — each class is a static factory (`::make()`) returning a `Filament\Forms\Components\Builder\Block`. These define the admin-side form schema for each block type.
- `src/FilamentComponents/ContentBuilder.php` — assembles blocks into a `Builder` for use in Filament form schemas. `::blocks($directory)` returns all blocks; `::columnBlocks($directory)` excludes `TwoColumnBlock` and `FormBuilderBlock` to prevent recursion inside column layouts.
- `src/Components/Blocks/` — Blade components that render each block type on the front end. They mirror the `FilamentBlocks/` one-to-one.
- `src/Traits/HasContentBlocks.php` — provides a `content_objects` computed attribute that decodes the raw array into nested `stdClass` objects for Blade. Models with a page builder use this trait. The field name defaults to `content`; override `contentBlocksField()` to change it.

### Models and Traits

- `src/Models/` — standard Eloquent models. `Page` uses `HasContentBlocks` and `HasSeo`.
- `src/Traits/HasSeo.php` — attaches SEO meta (via `SeoMeta` model).
- `src/Traits/HasCrownCmsFields.php` — added to the host app's `User` model; provides role and other CMS-specific fields.

### Settings

- `src/Settings/CompanySettings.php` — uses `spatie/laravel-settings` for persisted app-wide settings.
- `src/Pages/ManageCompany.php` — Filament settings page backed by `CompanySettings`.

### External Services

- `src/Services/LeisureKingService.php` — HTTP client for the LeisureKing ticketing API (configured via `CROWNCMS_LEISUREKING_*` env vars).
- `src/Commands/FetchReviews.php` / `FetchCurrencies.php` — Artisan commands that pull data from external APIs.

### Routing

Routes in `routes/web.php` are catch-all (`/{slug}`) and must always load last. The service provider uses `app->booted()` to guarantee this. The `HandleRedirects` middleware (added by the host app) intercepts requests before they reach the page controller.

## Configuration (`config/crown-cms.php`)

Key knobs:
- `layout` — Blade component name used as the site layout (default `layout`; host app must provide `x-layout` with the documented props).
- `views` — override the default page view.
- `models.user` — the host app's User model class.
- `routing.prefix` / `routing.middleware` — applied to all CMS page routes.
- `routes` — named route bindings for internal `show` links in the admin (set to `null` to hide the preview button for that resource).
- `buttons` — CSS class → label map used by `ButtonGroupBlock`.

## Adding a New Block

1. Create `src/FilamentBlocks/MyBlock.php` with a static `make(): Block` method.
2. Create the matching Blade component in `src/Components/Blocks/`.
3. Register it in `ContentBuilder::blocks()` (and `columnBlocks()` if appropriate).