<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'currency_id',
        'amount',
        'includes_vat',
        'label',
        'from_time',
        'to_time',
        'sort_order'
    ];

    /**
     * Get currency of price.
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the product of price.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to filter records with currency code 'EUR'.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInEuro(Builder $query): Builder
    {
        return $query->whereHas('currency', fn($q) => $q->where('code', 'EUR'));
    }
}
