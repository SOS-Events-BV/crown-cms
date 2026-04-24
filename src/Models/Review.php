<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reservation_hash',
        'firstname',
        'lastname',
        'stars',
        'review',
        'reaction',
        'language',
        'review_placed',
        'extra_attributes',
        'is_visible',
    ];

    protected $casts = [
        'extra_attributes' => 'array',
        'review_placed' => 'datetime',
    ];

    /**
     * Define an accessor for concatenating and returning the full name
     * by combining the firstname and lastname attributes with trimming.
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => trim("{$this->firstname} {$this->lastname}"),
        );
    }
}
