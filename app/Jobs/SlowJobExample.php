<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class SlowJobExample extends TrackedJob
{
    public function jobDisplayName(): string
    {
        return '🐌 Slow';
    }

    protected function run(): void
    {
        sleep(random_int(2, 4));
    }
}
