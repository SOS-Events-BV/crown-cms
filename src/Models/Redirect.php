<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = [
        'from',
        'to',
        'status_code',
    ];

    protected static function booted(): void
    {
        // When saving or deleting a redirect, clear the cache to ensure up-to-date data.
        static::saved(fn() => Cache::forget('redirects'));
        static::deleted(fn() => Cache::forget('redirects'));
    }
}
