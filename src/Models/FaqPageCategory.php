<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqPageCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all questions linked to the category.
     *
     * @return HasMany
     */
    public function faqPageQuestions(): HasMany
    {
        return $this->hasMany(FaqPageQuestion::class);
    }
}
