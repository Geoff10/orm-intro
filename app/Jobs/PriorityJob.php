<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class PriorityJob extends TrackedJob
{
    public $queue = 'priority';

    public function jobDisplayName(): string
    {
        return '👑 Priority';
    }

    protected function run(): void
    {
        sleep(3);
    }
}
