<?php

namespace SOSEventsBV\CrownCms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class TwoColumnBlock extends Component
{
    public array $layoutRatio;
    public ?string $backgroundColor;
    public ?string $textColor;
    public ?string $textStyle;
    public array $leftColumn;
    public array $rightColumn;
    public bool $centerContent = false;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public stdClass $data
    )
    {
        // Layout ratio
        $layoutRatio = $data->layout_ratio ?? '50_50';
        $this->layoutRatio = match ($layoutRatio) {
            '33_66' => ['left' => 'lg:col-span-4', 'right' => 'lg:col-span-8'],
            '66_33' => ['left' => 'lg:col-span-8', 'right' => 'lg:col-span-4'],
            '25_75' => ['left' => 'lg:col-span-3', 'right' => 'lg:col-span-9'],
            '75_25' => ['left' => 'lg:col-span-9', 'right' => 'lg:col-span-3'],
            default => ['left' => 'lg:col-span-6', 'right' => 'lg:col-span-6'],
        };

        // Background color
        $this->backgroundColor = $data->background_color ?? null;

        // Text color / style
        $this->textColor = $data->text_color ?? null;
        $this->textStyle = $this->textColor ?
            "color: {$this->textColor} !important; --tw-prose-body: {$this->textColor} !important; --tw-prose-headings: {$this->textColor} !important;
            --tw-prose-links: {$this->textColor} !important; --tw-prose-bullets: {$this->textColor} !important;"
            : null;


        // Content in left and right column
        $this->leftColumn = $data->left_column ?? [];
        $this->rightColumn = $data->right_column ?? [];

        // Centered
        $this->centerContent = $data->center_content ?? false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('crown-cms::components.blocks.two-column-block');
    }
}
