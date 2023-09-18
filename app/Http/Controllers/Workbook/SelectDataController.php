<?php

namespace App\Http\Controllers\Workbook;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SelectDataController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Workbook/SelectData');
    }
}
