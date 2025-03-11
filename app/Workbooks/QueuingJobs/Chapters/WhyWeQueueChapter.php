<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\SlowJobExample;
use App\Workbooks\Chapter;

class WhyWeQueueChapter extends Chapter
{
    public function id(): string
    {
        return 'whyWeQueue';
    }

    public function title(): string
    {
        return 'Why use queues?';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'p',
                'content' => 'Queues are a way to defer the processing of a time-consuming task, such as sending an email, to a later time. This can help to speed up the response time of your application.',
            ],
            [
                'type' => 'p',
                'content' => 'In addition to faster response times, queues can help smooth out traffic spikes and prevent your application from becoming overwhelmed during peak times.',
            ],
            [
                'type' => 'p',
                'content' => 'Here we are going to simulate a slow task that takes between 2 and 4 seconds to complete. This task is not being queued, so it will run in the current request.',
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Run slow job',
                "title" => "What if we don't use a queue?",
                'text' => [
                    'Try clicking this button lots of times in quick succession.',
                ],
                'code' => function (): array {
                    SlowJobExample::dispatchSync(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
