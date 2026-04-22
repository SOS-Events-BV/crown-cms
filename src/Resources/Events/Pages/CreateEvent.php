<?php

namespace SOSEventsBV\CrownCms\Resources\Events\Pages;

use Filament\Resources\Pages\CreateRecord;
use SOSEventsBV\CrownCms\Resources\Events\EventResource;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
