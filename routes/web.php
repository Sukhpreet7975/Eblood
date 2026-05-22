<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/search', [DonorController::class, 'search']);
Route::get('/live-search', [DonorController::class, 'liveSearch']);

/*
|--------------------------------------------------------------------------
| Requester Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'requester'])->group(function () {

    Route::get('/requester/home', [RequestController::class, 'requesterHome'])
        ->name('requester.home');

    Route::get('/blood-request', [RequestController::class, 'create']);
    Route::post('/blood-request', [RequestController::class, 'store']);

    Route::get('/my-requests', [RequestController::class, 'myRequests']);
    Route::get('/request/{id}', [RequestController::class, 'show']);
    Route::post('/request/{id}/cancel', [RequestController::class, 'cancel'])->name('request.cancel');

});

Route::middleware(['auth', 'donor'])->group(function () {

    // Donor home/dashboard
    Route::get('/donor/home', [DonorController::class, 'donorHome'])
        ->name('donor.home');

    Route::get('/become-donor', [DonorController::class, 'create']);

    Route::post('/save-donor', [DonorController::class, 'store']);

    Route::get('/profile', [DonorController::class, 'profile']);

    Route::get('/profile/edit', [DonorController::class, 'edit']);

    Route::post('/profile/update', [DonorController::class, 'update']);

    Route::get('/toggle-status', [DonorController::class, 'toggleStatus']);

    // AJAX toggle availability (authenticated donors only)
    Route::post('/toggle-availability', [DonorController::class, 'toggleAvailability'])->name('toggle.availability');

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

            Route::get('/home', [AdminController::class, 'home'])
            ->name('home');

        Route::get('/requests', [AdminController::class, 'requests'])
            ->name('requests.index');

        Route::get('/requests/{id}', [AdminController::class, 'showRequest'])
            ->name('requests.show');

        Route::post('/requests/{id}/status', [AdminController::class, 'updateRequestStatus'])
            ->name('requests.status');

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