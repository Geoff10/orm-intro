<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData\Chapters;

use App\Workbooks\Chapter;

class FilteringDataChapter extends Chapter
{
    public function id(): string
    {
        return 'filteringData';
    }

    public function title(): string
    {
        return 'Filtering Records';
    }

    public function content(): array
    {
        return [
            [
                "type" => "h2",
                "content" => "Filtering Data",
            ],
        ];
    }
}
