<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\SlowJobExample;
use App\Workbooks\Chapter;

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
                "title" => "What if we don't use a queue?",
                'text' => [
                    'Here we are going to simulate a slow task that takes between 1 and 5 seconds to complete. This task is not being queued, so it will run immediately.',
                ],
                'code' => function (): array {
                    SlowJobExample::dispatchSync(session()->get('session_identifier'));

                    return [];
                },
            ],
            [
                'type' => 'runnableCodeBlock',
                "title" => "Add to Queue",
                'text' => [
                    'Put a new task in the queue.',
                ],
                'code' => function (): array {
                    SlowJobExample::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ]
        ];
    }
}
