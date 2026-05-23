<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.home');
        })->name('index');

        Route::get('/home', [AdminController::class, 'home'])->name('home');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/requests', [AdminController::class, 'requests'])->name('requests.index');
        Route::get('/requests/{id}', [AdminController::class, 'showRequest'])->name('requests.show');
        Route::post('/requests/{id}/status', [AdminController::class, 'updateRequestStatus'])->name('requests.status');
        Route::get('/donors', [AdminController::class, 'manageDonors'])->name('donors.index');
        Route::get('/requesters', [AdminController::class, 'manageRequesters'])->name('requesters.index');
        Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');
        Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export-pdf', [AdminController::class, 'exportPdf'])->name('export-pdf');
    });
