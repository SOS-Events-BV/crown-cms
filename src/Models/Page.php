<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use SOSEventsBV\CrownCms\Traits\HasContentBlocks;
use SOSEventsBV\CrownCms\Traits\HasSeo;

class Page extends Model
{
    use HasSeo, HasContentBlocks;

    protected $fillable = [
        // Content
        'slug',
        'content',

        // Settings
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
