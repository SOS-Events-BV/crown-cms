<?php

namespace SOSEventsBV\CrownCms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LeisurekingFrame extends Component
{
    public string $bookingmodule_code;
    public string $url;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public \stdClass $data
    )
    {
        $this->bookingmodule_code = $data->bookingmodule_code;

        $this->url = url()->query("https://booking.leisureking.eu/bm/$this->bookingmodule_code", [
            'no-scroll' => $data->no_scroll,
            'date' => $data->date,
            'min_date' => $data->min_date,
            'max_date' => $data->max_date,
            'lang' => $data->lang
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('crown-cms::components.blocks.leisureking-frame');
    }
}
