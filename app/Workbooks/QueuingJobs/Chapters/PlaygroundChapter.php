<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\DelayedJob;
use App\Jobs\PriorityJob;
use App\Jobs\RetryBackoffJob;
use App\Jobs\RetryJob;
use App\Jobs\RiskyJob;
use App\Jobs\SlowJobExample;
use App\Workbooks\Chapter;

class PlaygroundChapter extends Chapter
{
    public function id(): string
    {
        return 'playground';
    }

    public function title(): string
    {
        return 'Playground';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'triggerButton',
                'buttonText' => 'Run without queue',
                "title" => "What if we don't use a queue?",
                'text' => [],
                'code' => function (): array {
                    SlowJobExample::dispatchSync(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue slow job',
                "title" => "Using a queued job",
                'text' => [],
                'code' => function (): array {
                    SlowJobExample::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue priority job',
                "title" => "Create priority job",
                'text' => [],
                'code' => function (): array {
                    PriorityJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue delayed job',
                "title" => "Create delayed job",
                'text' => [],
                'code' => function (): array {
                    DelayedJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue risky job',
                "title" => "Create a risky job",
                'text' => [],
                'code' => function (): array {
                    RiskyJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue retry job',
                "title" => "Create many risky job",
                'text' => [],
                'code' => function (): array {
                    RetryJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue retry job with backoff',
                "title" => "Create many risky job",
                'text' => [],
                'code' => function (): array {
                    RetryBackoffJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
