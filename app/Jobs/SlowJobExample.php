<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class SlowJobExample extends TrackedJob
{
    public function handle(): void
    {
        $this->updateStatus('processing');

        sleep(random_int(1, 5));

        $this->updateStatus('completed');
    }
}
