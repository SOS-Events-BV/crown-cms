<?php

namespace SOSEventsBV\CrownCms\Traits;

use SOSEventsBV\CrownCms\Models\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeo
{
    /**
     * Define a one-to-one polymorphic relationship for SEO metadata.
     *
     * @return MorphOne
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    protected static function bootHasSeo(): void
    {
        // Delete seo meta when deleting the model
        static::deleting(function ($model) {
            $model->seo()->delete();
        });
    }
}
