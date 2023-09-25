<?php

declare(strict_types=1);

namespace App\Workbooks\EloquentSelectData;

use App\Workbooks\EloquentSelectData\Chapters\BulkInsertingDataChapter;
use App\Workbooks\EloquentSelectData\Chapters\FilteringDataChapter;
use App\Workbooks\EloquentSelectData\Chapters\InsertingDataChapter;
use App\Workbooks\EloquentSelectData\Chapters\QueryingRelatedData;
use App\Workbooks\EloquentSelectData\Chapters\SelectDataByIdChapter;
use App\Workbooks\EloquentSelectData\Chapters\SelectDataChapter;
use App\Workbooks\EloquentSelectData\Chapters\SelectSpecificColumnsChapter;
use App\Workbooks\EloquentSelectData\Chapters\SortingDataChapter;
use App\Workbooks\Workbook;

class EloquentSelectData extends Workbook
{
    public function id(): string
    {
        return 'eloquentSelectData';
    }

    public function title(): string
    {
        return 'Eloquent Select Data';
    }

    public function chapters(): array
    {
        return [
            new SelectDataChapter(),
            new SelectSpecificColumnsChapter(),
            new SelectDataByIdChapter(),
            new FilteringDataChapter(),
            new SortingDataChapter(),
            new InsertingDataChapter(),
            new BulkInsertingDataChapter(),
            new QueryingRelatedData(),
        ];
    }
}
