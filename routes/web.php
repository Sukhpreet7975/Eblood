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
// Emergency request routes require authentication so users can track status
// Access is controlled in controller to prevent admins from creating requests


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

    // Emergency Request Routes (authenticated users only)
    Route::get('/blood-request', [RequestController::class, 'create']);
    Route::post('/blood-request', [RequestController::class, 'store']);

    // User request pages
    Route::get('/my-requests', [RequestController::class, 'myRequests']);
    Route::get('/request/{id}', [RequestController::class, 'show']);
    Route::post('/request/{id}/cancel', [RequestController::class, 'cancel'])->name('request.cancel');

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

        // Update request status
        Route::post('/request/{id}/status', [AdminController::class, 'updateRequestStatus'])
            ->name('request-status');

    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';