<?php

namespace SOSEventsBV\CrownCms;

use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SOSEventsBV\CrownCms\Commands\CrownCmsCommand;
use SOSEventsBV\CrownCms\Testing\TestsCrownCms;

class CrownCmsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'crown-cms';

    public static string $viewNamespace = 'crown-cms';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->discoversMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $command) {
                        $command->call('vendor:publish', [
                            '--tag' => 'crown-cms-layout',
                        ]);
                        $command->call('filament:assets');
                    });
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Add routes to the website of the user
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Add components to the website of the user
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->componentNamespace('SOSEventsBV\\CrownCms\\Components', 'crown-cms');
        });

        // Publish the layout
        $this->publishes([
            __DIR__ . '/../resources/views/components/layout.blade.php' => resource_path('views/components/layout.blade.php')
        ], 'crown-cms-layout');

        // Testing
        Testable::mixin(new TestsCrownCms);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'sos-events-bv/crown-cms';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('crown-cms', __DIR__ . '/../resources/dist/components/crown-cms.js'),
            // Css::make('crown-cms-styles', __DIR__ . '/../resources/dist/crown-cms.css'),
            // Js::make('crown-cms-scripts', __DIR__ . '/../resources/dist/crown-cms.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            CrownCmsCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }
}
