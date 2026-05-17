<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DonorController::class, 'home']);
Route::get('/search', [DonorController::class, 'search']);
Route::get('/live-search', [DonorController::class, 'liveSearch']);
Route::get('/blood-request', [RequestController::class, 'create']);
Route::post('/blood-request', [RequestController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Donor / User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DonorController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/become-donor', [DonorController::class, 'create']);

    Route::post('/save-donor', [DonorController::class, 'store']);

    Route::get('/profile', [DonorController::class, 'profile']);

    Route::get('/profile/edit', [DonorController::class, 'edit']);

    Route::post('/profile/update', [DonorController::class, 'update']);

    Route::get('/toggle-status', [DonorController::class, 'toggleStatus']);

    Route::post('/upload-image', [DonorController::class, 'uploadImage']);

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])
            ->name('delete-user');

        Route::get('/export-excel', [AdminController::class, 'exportExcel'])
            ->name('export-excel');

        Route::get('/export-pdf', [AdminController::class, 'exportPdf'])
            ->name('export-pdf');

    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';