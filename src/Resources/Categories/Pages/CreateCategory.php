<?php

namespace SOSEventsBV\CrownCms\Resources\Categories\Pages;

use Filament\Resources\Pages\CreateRecord;
use SOSEventsBV\CrownCms\Resources\Categories\CategoryResource;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
