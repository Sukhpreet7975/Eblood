<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RequestsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DonorsController;
use App\Http\Controllers\Admin\AnalyticsController;
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
        Route::get('/requests', [RequestsController::class, 'index'])->name('requests.index');
        Route::get('/requests/{id}', [RequestsController::class, 'show'])->name('requests.show');
        Route::post('/requests/{id}/status', [RequestsController::class, 'updateStatus'])->name('requests.status');
        Route::get('/donors', [DonorsController::class, 'index'])->name('donors.index');
        Route::get('/requesters', [AdminController::class, 'manageRequesters'])->name('requesters.index');
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
        // Unified users management
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/suspend', [UsersController::class, 'suspend'])->name('users.suspend');
        Route::post('/users/{id}/toggle-donor', [UsersController::class, 'toggleDonor'])->name('users.toggle-donor');
        Route::get('/delete-user/{id}', [UsersController::class, 'delete'])->name('delete-user');
        Route::get('/export-excel', [UsersController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export-pdf', [UsersController::class, 'exportPdf'])->name('export-pdf');
    });
