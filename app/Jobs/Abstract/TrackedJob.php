<?php

namespace App\Jobs\Traits;

use App\Events\JobStatusChanged;
use Illuminate\Foundation\Queue\Queueable;

abstract class TrackedJob
{
    use Queueable;

    readonly public string $id;

    public function __construct()
    {
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
            session()->get('session_identifier'),
            $this->id,
            $status,
        );
    }
}
