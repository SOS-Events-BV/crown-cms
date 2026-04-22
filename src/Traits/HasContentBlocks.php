<?php

namespace SOSEventsBV\CrownCms\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasContentBlocks
{
    /**
     * The field name that holds the content blocks.
     * Override this in your model if the field is named differently.
     */
    protected function contentBlocksField(): string
    {
        return 'content';
    }

    /**
     * Returns the content blocks as nested stdClass objects, suited for use in Blade views.
     * Filament reads the raw array via the model cast — this accessor is only for views.
     */
    protected function contentObjects(): Attribute
    {
        return Attribute::get(
            fn() => json_decode(json_encode($this->{$this->contentBlocksField()}))
        );
    }
}
