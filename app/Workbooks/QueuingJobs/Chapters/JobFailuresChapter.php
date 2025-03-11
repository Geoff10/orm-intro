<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\RiskyJob;
use App\Workbooks\Chapter;

class JobFailuresChapter extends Chapter
{
    public function id(): string
    {
        return 'jobFailures';
    }

    public function title(): string
    {
        return 'Job Failures';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'p',
                'content' => 'Sometimes jobs don\t complete successfully. A handy thing about jobs is that they run in isolation, so if one jobs fails others will still carry on.',
            ],
            [
                'type' => 'p',
                'content' => 'You can add additional logic when your job fails by adding a failed mathod to your job class.'
            ],
            [
                'type' => 'codeBlock',
                'text' => 'public function failed(Exception $exception)
{
    Log::error("Job failed", ["exception" => $exception]);
}',
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue risky jobs',
                "title" => "Create many risky jobs",
                'text' => [
                    'Try clicking this button to create multiple risky priority jobs'
                ],
                'code' => function (): array {
                    for ($i=0; $i < 8; $i++) {
                        RiskyJob::dispatch(session()->get('session_identifier'));
                    }

                    return [];
                },
            ],
        ];
    }
}
