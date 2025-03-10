<?php

namespace App\Jobs;

use App\Jobs\Traits\TrackedJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SlowJobExample extends TrackedJob implements ShouldQueue
{
    public function handle(): void
    {
        $this->updateStatus('processing');

        sleep(random_int(1, 5));

        $this->updateStatus('completed');
    }
}
