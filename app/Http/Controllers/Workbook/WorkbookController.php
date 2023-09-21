<?php

namespace App\Http\Controllers\Workbook;

use App\Http\Controllers\Controller;
use App\Workbooks\SelectData;
use App\Workbooks\SelectDataById;
use Inertia\Inertia;
use Inertia\Response;

class WorkbookController extends Controller
{
    private $workbooks = [
        'selectData' => SelectData::class,
        'selectDataById' => SelectDataById::class,
    ];

    public function __invoke(string $workbook): Response
    {
        $workbook = $this->workbooks[$workbook] ?? null;

        if (!$workbook) {
            return abort(404);
        }

        return Inertia::render('Workbook/SelectData', [
            'workbook' => (new $workbook)->toArray(),
        ]);
    }
}
