<?php

namespace App\Jobs\Abstracts;

use App\Events\JobStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

abstract class TrackedJob implements ShouldQueue
{
    use Dispatchable;
    use Queueable;

    public string $id;

    public function __construct(
        protected string $uniqueSessionId,
    ) {
        $this->id = substr(md5(random_int(1, 1_000_000_000_000)), -12);

        $this->updateStatus('queued');
    }

    public function failed(): void
    {
        $this->updateStatus('failed');
    }

    protected function updateStatus(string $status): void
    {
        JobStatusChanged::dispatch(
            $this->uniqueSessionId,
            $this->id,
            $status,
        );
    }
}
