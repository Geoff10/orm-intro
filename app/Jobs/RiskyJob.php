<?php

namespace App\Jobs;

use App\Jobs\Abstracts\TrackedJob;

class RiskyJob extends TrackedJob
{
    public $queue = 'priority';

    public function jobDisplayName(): string
    {
        return '⚠️ Risky';
    }

    protected function run(): void
    {
        sleep(1);
        if (random_int(1, 3) === 1 ) {
            throw new \Exception('Couldn\'t contact the external service!');
        }
    }
}
