<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs\Chapters;

use App\Jobs\SlowJobExample;
use App\Workbooks\Chapter;

class CreatingAJobChapter extends Chapter
{
    public function id(): string
    {
        return 'creatingAJob';
    }

    public function title(): string
    {
        return 'Creating a Job';
    }

    public function content(): array
    {
        return [
            [
                'type' => 'p',
                'content' => 'To create a job, you need to create a new class that extends the `Job` class. This class should implement the `handle` method, which is where the job logic goes.',
            ],
            [
                'type' => 'p',
                'content' => 'Here is an example of a job that simulates a slow task that takes between 2 and 4 seconds to complete.',
            ],
            [
                'type' => 'codeBlock',
                'text' => 'use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SlowJobExample implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        sleep(rand(2, 4));

        logger("Slow job completed");
    }
}',
            ],
            [
                'type' => 'p',
                'content' => 'This job uses the `sleep` function to simulate a slow task. The `rand(2, 4)` function is used to generate a random number between 2 and 4, which determines how long the task will take to complete.',
            ],
            [
                'type' => 'p',
                'content' => 'To dispatch this job, you can use the `dispatch` method on the job class. Here is an example of how to dispatch the `SlowJobExample` job:',
            ],
            [
                'type' => 'codeBlock',
                'text' => 'SlowJobExample::dispatch();',
            ],
            [
                'type' => 'p',
                'content' => 'This will add the job to the queue, where it will be processed by a worker. The worker will call the `handle` method on the job class, which will run the job logic.',
            ],
            [
                'type' => 'p',
                'content' => 'Try using the button below to run the `SlowJobExample` job.',
            ],
            [
                'type' => 'triggerButton',
                'buttonText' => 'Queue slow job',
                "title" => "Using a queued job",
                'text' => [
                    'Try clicking this button lots of times in quick succession.',
                ],
                'code' => function (): array {
                    SlowJobExample::dispatch(session()->get('session_identifier'));

                    return [];
                },
            ],
        ];
    }
}
