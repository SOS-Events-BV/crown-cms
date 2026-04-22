<?php

namespace SOSEventsBV\CrownCms\Models;

use SOSEventsBV\CrownCms\Traits\HasSeo;
use SOSEventsBV\CrownCms\Traits\HasContentBlocks;
use Illuminate\Database\Eloquent\Model;

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
