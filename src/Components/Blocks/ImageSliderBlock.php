<?php

namespace SOSEventsBV\CrownCms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class ImageSliderBlock extends Component
{
    public array $config;
    public bool $hasNavigation;
    public bool $hasPagination;
    public array $images;

    /**
     * Create a new component instance.
     */
    public function __construct(
        /** @var stdClass */
        public stdClass $data
    )
    {
        // Generate config based on what was filled in Filament
        $this->config = [
            'loop' => $data->loop ?? false,
            'navigation' => $data->navigation ?? false,
            'autoplay' => $data->autoplay ?? false,
            'autoplaySpeed' => $data->autoplay_speed ?? 3000,
            'pagination' => $data->pagination ?? false,
            'spaceBetween' => $data->space_between ?? 20,
            'breakpoints' => [
                0 => ['slidesPerView' => $data->slides_mobile ?? 1],
                640 => ['slidesPerView' => $data->slides_tablet ?? 2],
                1024 => ['slidesPerView' => $data->slides_desktop ?? 3],
            ],
        ];
        $this->hasNavigation = $data->navigation ?? false;
        $this->hasPagination = $data->pagination ?? false;

        $this->images = $data->images;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('crown-cms::components.blocks.image-slider-block');
    }
}
