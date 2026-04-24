<?php

namespace SOSEventsBV\CrownCms;

use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Pboivin\FilamentPeek\FilamentPeekPlugin;
use SOSEventsBV\CrownCms\Pages\ManageCompany;
use SOSEventsBV\CrownCms\Resources\Categories\CategoryResource;
use SOSEventsBV\CrownCms\Resources\Events\EventResource;
use SOSEventsBV\CrownCms\Resources\FaqPageQuestions\FaqPageQuestionResource;
use SOSEventsBV\CrownCms\Resources\Pages\PageResource;
use SOSEventsBV\CrownCms\Resources\Products\ProductResource;
use SOSEventsBV\CrownCms\Resources\Redirects\RedirectResource;
use SOSEventsBV\CrownCms\Resources\Reviews\ReviewResource;
use SOSEventsBV\CrownCms\Resources\Users\UserResource;

class CrownCmsPlugin implements Plugin
{
    protected bool $withReviews = true;
    protected bool $withFaq = true;
    protected bool $withEvents = true;
    protected bool $withProducts = true;

    public function withoutReviews(): self
    {
        $this->withReviews = false;
        return $this;
    }

    public function withoutFaq(): self
    {
        $this->withFaq = false;
        return $this;
    }

    public function withoutEvents(): self
    {
        $this->withEvents = false;
        return $this;
    }

    public function withoutProducts(): self
    {
        $this->withProducts = false;
        return $this;
    }

    public function getId(): string
    {
        return 'crown-cms';
    }

    public function register(Panel $panel): void
    {
        $resources = [
            PageResource::class,
            UserResource::class,
            RedirectResource::class,
        ];

        if ($this->withReviews) $resources[] = ReviewResource::class;
        if ($this->withFaq) $resources[] = FaqPageQuestionResource::class;
        if ($this->withEvents) $resources[] = EventResource::class;
        if ($this->withProducts) {
            $resources[] = CategoryResource::class;
            $resources[] = ProductResource::class;
        }

        $panel
            ->profile()
            ->passwordReset()
            ->plugins([
                FilamentPeekPlugin::make(),
            ])
            ->pages([
                ManageCompany::class
            ])
            ->resources($resources)
            ->navigationGroups([
                NavigationGroup::make()->label('Pagina\'s'),
                NavigationGroup::make()->label('Producten'),
                NavigationGroup::make()->label('Instellingen'),
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
