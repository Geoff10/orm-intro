<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class PriorityJob extends TrackedJob
{
    public $queue = 'priority';

    protected function run(): void
    {
        sleep(3);
    }
}
