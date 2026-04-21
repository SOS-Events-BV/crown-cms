<?php

namespace SOSEventsBV\CrownCms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SOSEventsBV\CrownCms\CrownCms
 */
class CrownCms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SOSEventsBV\CrownCms\CrownCms::class;
    }
}
