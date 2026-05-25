<?php

use App\Http\Controllers\Donor\DonorController;
use App\Http\Controllers\Requester\RequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [RequestController::class, 'dashboard'])->name('dashboard');
    Route::get('/search', [DonorController::class, 'search'])->name('search.index');
    Route::get('/live-search', [DonorController::class, 'liveSearch'])->name('search.live');

    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests', [RequestController::class, 'myRequests'])->name('requests.index');
    Route::get('/requests/{id}', [RequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{id}/cancel', [RequestController::class, 'cancel'])->name('requests.cancel');

    Route::get('/requester/home', [RequestController::class, 'requesterHome'])->name('requester.home');
    Route::get('/requester/search', [DonorController::class, 'search'])->name('requester.search.index');
    Route::get('/requester/live-search', [DonorController::class, 'liveSearch'])->name('requester.search.live');
    Route::get('/blood-request', [RequestController::class, 'create'])->name('requester.requests.create');
    Route::post('/blood-request', [RequestController::class, 'store'])->name('requester.requests.store');
    Route::get('/my-requests', [RequestController::class, 'myRequests'])->name('requester.requests.index');
    Route::get('/request/{id}', [RequestController::class, 'show'])->name('requester.requests.show');
    Route::post('/request/{id}/cancel', [RequestController::class, 'cancel'])->name('requester.requests.cancel');
});
