<?php

namespace SOSEventsBV\CrownCms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class VideoBlock extends Component
{
    public string $videoUrl;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $data
    )
    {
        $this->videoUrl = url()->query("https://www.youtube.com/embed/{$data->video_id}", [
            'autoplay' => $data->autoplay,
            'controls' => $data->controls,
            'mute' => $data->mute
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('crown-cms::components.blocks.video-block');
    }
}
