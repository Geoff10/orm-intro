<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\PriorityJob;
use App\Jobs\SlowJobExample;
use App\Workbooks\Chapter;

class PriorityJobsChapter extends Chapter
{
    public function id(): string
    {
        return 'priorityJobs';
    }

    public function title(): string
    {
        return 'Priority Jobs';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'h2',
                'content' => 'Setting up the queue worker',
            ],
            [
                'type' => 'p',
                'content' => 'In Laravel we set up a queue worker that will listen on the queue that jobs are added to by default we run the following.',
            ],
            [
                'type' => 'codeBlock',
                'text' => 'php artisan queue:work'
            ],
            [
                'type' => 'p',
                'content' => 'You can instead set up a queue worker to listen to jobs that are placed on a specific queue. For example, a high priority queue.'
            ],
            [
                'type' => 'codeBlock',
                'text' => 'php artisan queue:work --queue=priority'
            ],
            [
                'type' => 'p',
                'content' => 'You can also make a single queue worker watch multiple queues. The order you list the queues is the priority the worker will assign to them.'
            ],
            [
                'type' => 'codeBlock',
                'text' => 'php artisan queue:work --queue=priority,default'
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue slow jobs',
                "title" => "Create many standard jobs",
                'text' => [
                    'Try clicking this button to create multiple standard priority jobs'
                ],
                'code' => function (): array {
                    for ($i=0; $i < 5; $i++) {
                        SlowJobExample::dispatch(session()->get('session_identifier'));
                    }

                    return [];
                },
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue priority job',
                "title" => "Create priority job",
                'text' => [
                    'Try clicking this button to create a priority job. You can then see how the queue worker will prioritize this job over other jobs.',
                ],
                'code' => function (): array {
                    PriorityJob::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
