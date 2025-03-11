<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs;

use App\Workbooks\QueuingJobs\Chapters\CreatingAJobChapter;
use App\Workbooks\QueuingJobs\Chapters\JobFailuresChapter;
use App\Workbooks\QueuingJobs\Chapters\PriorityJobsChapter;
use App\Workbooks\QueuingJobs\Chapters\RetryingJobsChapter;
use App\Workbooks\QueuingJobs\Chapters\RetryingJobsWithDelayChapter;
use App\Workbooks\QueuingJobs\Chapters\WhyWeQueueChapter;
use App\Workbooks\Workbook;

class QueuingJobs extends Workbook
{
    public function id(): string
    {
        return 'queuingJobs';
    }

    public function title(): string
    {
        return 'Queuing Jobs';
    }

    public function chapters(): array
    {
        return [
            new WhyWeQueueChapter(),
            new CreatingAJobChapter(),
            new PriorityJobsChapter(),
            new JobFailuresChapter(),
            new RetryingJobsChapter(),
            new RetryingJobsWithDelayChapter(),
        ];
    }
}
