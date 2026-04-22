<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SOSEventsBV\CrownCms\Traits\HasSeo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasSeo, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'example_time_schemes',
        'is_active',
    ];

    protected $casts = [
        'example_time_schemes' => 'array',
    ];

    /**
     * Register media conversions for category images.
     *
     * 1. Thumb - Max width 600px
     * 2. Medium - Max width 1200px
     * 3. Large - Max width 2400px
     *
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Small thumbnails for overview pages
        $this
            ->addMediaConversion('thumb')
            ->width(600)
            ->format('webp')
            ->quality(80);

        // Large thumbnails for product detail pages
        $this
            ->addMediaConversion('medium')
            ->width(1200)
            ->format('webp')
            ->quality(80);

        // Large images for full-screen sliders and hero's
        $this
            ->addMediaConversion('large')
            ->width(2400)
            ->format('webp')
            ->quality(85);
    }

    /**
     * Get all products linked to the category.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
