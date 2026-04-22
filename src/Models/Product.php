<?php


namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use SOSEventsBV\CrownCms\Traits\HasSeo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasSeo, InteractsWithMedia;

    protected $fillable = [
        // Product
        'slug',
        'name',
        'summary',
        'description',
        'book_option',
        'forward_url',
        'forward_title',
        'forward_description',

        // LeisureKing values
        'leisureking_id',
        'leisureking_bookingmodule_hash',
        'excluded_fields_lk_sync',

        // Package fields (if is_package is true)
        'time_schemes',

        // Optional fields
        'location',
        'min_persons',
        'max_persons',
        'faqs',

        'is_package',
        'is_active',
    ];

    protected $casts = [
        'price_conversions' => 'array',
        'faqs' => 'array',
        'time_schemes' => 'array',
        'excluded_fields_lk_sync' => 'array',
    ];

    /**
     * Register media conversions for product images.
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
     * Get all the prices for the product.
     *
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Get all the prices for the product in euro.
     *
     * @return HasMany
     */
    public function euroPrices(): HasMany
    {
        return $this->prices()->inEuro();
    }

    /**
     * Get all the categories for the product.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the faqs as an object to use -> instead of []
     *
     * @return Attribute
     */
    protected function faqsObject(): Attribute
    {
        return Attribute::make(
            get: fn() => json_decode($this->attributes['faqs'] ?? '[]')
        );
    }
}
