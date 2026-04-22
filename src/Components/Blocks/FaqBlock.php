<?php

namespace SOSEventsBV\CrownCms\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\SchemaOrg\FAQPage;
use Spatie\SchemaOrg\Schema;
use stdClass;

class FaqBlock extends Component
{
    public array $faqs;
    public FAQPage $faqSchema;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public array|stdClass $data
    )
    {
        $this->faqs = $data->faqs ?? $data;

        // Generate FAQ Schema for Google
        $this->faqSchema = Schema::fAQPage()
            ->mainEntity(
                collect($this->faqs)->map(function ($faq) {
                    return Schema::question()
                        ->name($faq->question)
                        ->acceptedAnswer(Schema::Answer()->text(strip_tags($faq->answer)));
                })->values()->toArray()
            );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('crown-cms::components.blocks.faq-block');
    }
}
