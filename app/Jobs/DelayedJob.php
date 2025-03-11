<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class DelayedJob extends TrackedJob
{
    public $delay = 5;

    public function jobDisplayName(): string
    {
        return '⏸️ Delayed';
    }

    protected function run(): void
    {
        sleep(2);
    }
}
