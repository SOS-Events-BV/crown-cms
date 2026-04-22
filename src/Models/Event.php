<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'page_id',
        'name',
        'start_date',
        'end_date',
        'summary',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Register media conversions for event images.
     *
     * 1. Thumb - Max width 600px
     * 2. Medium - Max width 1200px
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

        // Large thumbnails for event detail pages
        $this
            ->addMediaConversion('medium')
            ->width(1200)
            ->format('webp')
            ->quality(80);
    }

    /**
     * Get the page linked to the event.
     *
     * @return BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
