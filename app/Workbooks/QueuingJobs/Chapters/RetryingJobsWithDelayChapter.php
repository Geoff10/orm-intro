<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\RetryBackoffJob;
use App\Workbooks\Chapter;

class RetryingJobsWithDelayChapter extends Chapter
{
    public function id(): string
    {
        return 'retryingJobsWithDelay';
    }

    public function title(): string
    {
        return 'Retrying Jobs with a Delay';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'p',
                'content' => 'Jobs that retry can be configured to wait a certain amount of time before retrying.',
            ],
            [
                'type' => 'p',
                'content' => 'To configure a delay between retries, you can set the $backoff property on the job class. This property determines how many seconds the job will wait before retrying. By default, jobs are retried immediately.',
            ],
            [
                'type' => 'codeBlock',
                'text' => 'class RetryJob extends Job
{
    public $tries = 3;
    public $backoff = [2, 5];

    public function handle()
    {
        // Job logic...
    }
}'
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue retry jobs',
                "title" => "Create many risky job",
                'text' => [
                    'Try clicking this button to a job that will retry.'
                ],
                'code' => function (): array {
                    RetryBackoffJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
