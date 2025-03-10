<?php

namespace App\Jobs;

use App\Events\JobStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SlowJobExample implements ShouldQueue
{
    use Queueable;

    readonly public string $id;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->id = substr(md5(random_int(1, 1_000_000_000_000)), -12);

        $this->updateStatus('queued');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->updateStatus('processing');

        sleep(random_int(1, 5));

        $this->updateStatus('completed');
    }

    private function updateStatus(string $status): void
    {
        JobStatusChanged::dispatch(
            session()->get('session_identifier'),
            $this->id,
            $status,
        );
    }
}
