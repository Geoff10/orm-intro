<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Events\JobStatusChanged;
use App\Workbooks\Chapter;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class IntroductionChapter extends Chapter
{
    public function id(): string
    {
        return 'introduction';
    }

    public function title(): string
    {
        return 'Introduction to Queues';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "What are Queues?",
            ],
            [
                'type' => 'p',
                'content' => 'A queue is an ordered list of tasks waiting to be processed. They behave much like queues of people do in daily life. When a task is added to a queue, it is placed at the end. The next task to be processed is always the one at the front of the queue.',
                // 'content' => 'Queues are a way to defer the processing of a time-consuming task, such as sending an email, to a later time. This can help to speed up the response time of your application.',
            ],
            [
                'type' => 'runnableCodeBlock',
                "title" => "Add to Queue",
                'text' => [
                    'Put a new task in the queue.',
                ],
                'code' => function (): array {
                    Log::info('Queued a job');

                    Broadcast::on('session.' . session()->get('session_identifier'))
                        ->as('JobStatusChanged')
                        ->with([
                            'jobId' => 123,
                            'status' => 'queued',
                        ])
                        ->sendNow();

                    // JobStatusChanged::dispatch(
                    //     session()->get('session_identifier'),
                    //     123,
                    //     'Queued',
                    // );

                    return [];
                },
            ]
        ];
    }
}
