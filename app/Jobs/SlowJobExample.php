<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class SlowJobExample extends TrackedJob
{
    protected function run(): void
    {
        sleep(random_int(1, 5));
    }
}
