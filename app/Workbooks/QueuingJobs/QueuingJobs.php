<?php

declare(strict_types=1);

namespace App\Workbooks\QueuingJobs;

use App\Workbooks\QueuingJobs\Chapters\IntroductionChapter;
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
        ];
    }
}
