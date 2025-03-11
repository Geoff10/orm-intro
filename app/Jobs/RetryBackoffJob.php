<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;
use Illuminate\Support\Facades\Cache;

class RetryBackoffJob extends TrackedJob
{
    public $tries = 3;
    public $backoff = [2, 5];

    public function jobDisplayName(): string
    {
        return '⏳ Delay Retry';
    }

    protected function run(): void
    {
        sleep(1);

        if ($this->attempts() !== 3) {
            Cache::decrement("user-{$this->uniqueSessionId}-usage");
            $this->updateStatus('failed', 'Couldn\'t contact the external service!');
            throw new \Exception('Couldn\'t contact the external service!');
        }
    }
}
