<?php

namespace SOSEventsBV\CrownCms\Commands;

use Illuminate\Console\Command;

class CrownCmsCommand extends Command
{
    public $signature = 'crown-cms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
