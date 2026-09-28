<?php

namespace SOSEventsBV\CrownCms\Models;

use Illuminate\Database\Eloquent\Model;
use SOSEventsBV\CrownCms\Traits\HasContentBlocks;
use SOSEventsBV\CrownCms\Traits\HasSeo;

class Page extends Model
{
    use HasSeo, HasContentBlocks;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
