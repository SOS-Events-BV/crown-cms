<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqPageQuestion extends Model
{
    protected $fillable = [
        'faq_page_category_id',
        'question',
        'answer'
    ];

    /**
     * Get the category linked to this question.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqPageCategory::class, 'faq_page_category_id');
    }
}
