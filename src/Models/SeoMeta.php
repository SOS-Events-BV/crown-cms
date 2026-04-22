<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $fillable = [
        'seoable_id',
        'seoable_type',
        'page_title',
        'page_description',
        'page_keywords',
        'og_title',
        'og_description',
        'og_image'
    ];

    /**
     * Get the parent seoable model.
     *
     * @return MorphTo
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
