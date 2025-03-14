<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Workbook\WorkbookController;
use App\Http\Middleware\EnsureSessionHasUniqueId;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(EnsureSessionHasUniqueId::class)->group(function () {
    Route::redirect('/', '/wb/eloquentSelectData/selectData');

    Route::get('wb/{workbook}/{chapter}', WorkbookController::class)->name('workbook');

    Route::get('example/{module}/{exercise}', ExampleController::class)
        ->name('example');

    Route::get('preview/{workbook}/{chapter}/{exercise}', PreviewController::class)
        ->name('preview');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
