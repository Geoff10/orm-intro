<?php

namespace App\Http\Controllers\Workbook;

use App\Http\Controllers\Controller;
use App\Workbooks\EloquentSelectData\EloquentSelectData;
use Inertia\Inertia;
use Inertia\Response;

class WorkbookController extends Controller
{
    // TODO: Key this dynamically from the workbooks IDs
    private $workbooks = [
        'eloquentSelectData' => EloquentSelectData::class,
    ];

    public function __invoke(string $workbook, ?string $chapter): Response
    {
        $workbook = $this->workbooks[$workbook] ?? null;

        if (!$workbook) {
            return abort(404);
        }

        $workbook = new $workbook;

        if ($chapter) {
            $chapter = $workbook->getChapter($chapter);

            if (!$chapter) {
                return abort(404);
            }

            $props = [
                'uniqueSessionId' => session()->get('session_identifier'),
                'workbook' => $workbook->toArray(),
                'chapter' => $chapter->toArray(),
                'next_chapter' => $workbook->getNextChapter($chapter->id())?->toArray(['id', 'title']),
                'previous_chapter' => $workbook->getPreviousChapter($chapter->id())?->toArray(['id', 'title']),
            ];

            // TODO: Make this use something more generic than the workbook ID. Eg. a type property on the workbook
            return match ($workbook->id()) {
                'eloquentSelectData' => Inertia::render('WorkbookTypes/DatabaseQueries', $props),
                'queuingJobs' => Inertia::render('WorkbookTypes/Queues', $props),
                default => abort(404, 'Unknown workbook type'),
            };
        }

        return abort(404);
    }
}
