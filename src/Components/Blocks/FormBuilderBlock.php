<?php

namespace SOSEventsBV\CrownCms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class FormBuilderBlock extends Component
{
    public array $formInputs;
    public string $postRoute;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $data
    )
    {
        $this->formInputs = $data->form_inputs;
        $this->postRoute = route('page.submit', isset(request()->slug) ? request()->slug : ' ');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('crown-cms::components.blocks.form-builder-block');
    }
}
