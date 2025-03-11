<?php

namespace App\Jobs\Abstracts;

use App\Events\JobStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Throwable;

abstract class TrackedJob implements ShouldQueue
{
    use Queueable;

    public string $id;

    abstract protected function run(): void;

    public function __construct(
        protected string $uniqueSessionId,
    ) {
        $this->id = substr(md5(random_int(1, 1_000_000_000_000)), -12);

        $this->updateStatus('queued');
    }

    public function failed(Throwable $e): void
    {
        $this->updateStatus('failed', $e->getMessage());
    }

    public function handle(): void
    {
        if (Cache::get("user-{$this->uniqueSessionId}-usage", 0) >= 4) {
            $this->fail('You are performing too many actions at once. Please wait a moment and try again.');
            return;
        }

        Cache::increment("user-{$this->uniqueSessionId}-usage");

        $this->updateStatus('processing');

        $this->run();

        Cache::decrement("user-{$this->uniqueSessionId}-usage");

        $this->updateStatus('completed');
    }

    protected function updateStatus(string $status, ?string $message = null): void
    {
        JobStatusChanged::dispatch(
            $this->uniqueSessionId,
            $this->id,
            $status,
            $message,
        );
    }
}
