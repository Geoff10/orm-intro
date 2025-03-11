<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\RetryJob;
use App\Workbooks\Chapter;

class RetryingJobsChapter extends Chapter
{
    public function id(): string
    {
        return 'retryingJobs';
    }

    public function title(): string
    {
        return 'Retrying Jobs';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'p',
                'content' => 'Jobs can be set up to retry automatically if they fail. This can be useful for jobs that interact with external services that may be temporarily unavailable.',
            ],
            [
                'type' => 'p',
                'content' => 'To enable automatic retries, you can set the $tries property on the job class. This property determines how many times the job will be retried if it fails. By default, jobs are retried three times.',
            ],
            [
                'type' => 'codeBlock',
                'text' => 'class RetryJob extends Job
{
    public $tries = 3;

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
                    RetryJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
