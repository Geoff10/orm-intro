<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\DelayedJob;
use App\Workbooks\Chapter;

class DelayJobsStartChapter extends Chapter
{
    public function id(): string
    {
        return 'delayJobsStart';
    }

    public function title(): string
    {
        return 'Delay a Jobs Start';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'p',
                'content' => 'Instead of being available immediately, jobs can be configured to wait a certain amount of time before starting. This can be useful for jobs that need to wait for a specific time before running.',
            ],
            [
                'type' => 'p',
                'content' => 'For example, you might want to allow some time for a user to cancel an action before it is processed.',
            ],
            [
                'type' => 'p',
                'content' => 'To configure a delay before a job starts, you can set the $delay property on the job class. This property determines how many seconds the job will wait before starting. By default, jobs start immediately.',
            ],
            [
                'type' => 'codeBlock',
                'text' => 'class RetryJob extends Job
{
    public $delay = 5;

    public function handle()
    {
        // Job logic...
    }
}'
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue delayed jobs',
                "title" => "Create delayed job",
                'text' => [
                    'Try clicking this button to add a delayed job.'
                ],
                'code' => function (): array {
                    DelayedJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
