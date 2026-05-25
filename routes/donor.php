<?php

use App\Http\Controllers\Donor\DonorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/donor/home', [DonorController::class, 'donorHome'])->name('donor.home');
    Route::get('/become-donor', [DonorController::class, 'create'])->name('donor.become');
    Route::post('/save-donor', [DonorController::class, 'store'])->name('donor.store');
    Route::get('/profile', [DonorController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [DonorController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [DonorController::class, 'update'])->name('profile.update');
    Route::get('/toggle-status', [DonorController::class, 'toggleStatus'])->name('donor.status.toggle');
    Route::post('/toggle-availability', [DonorController::class, 'toggleAvailability'])->name('toggle.availability');
    Route::post('/upload-image', [DonorController::class, 'uploadImage'])->name('donor.image.upload');
    Route::get('/donor/profile', [DonorController::class, 'profile'])->name('donor.profile');
    Route::get('/donor/profile/edit', [DonorController::class, 'edit'])->name('donor.profile.edit');
    Route::post('/donor/profile/update', [DonorController::class, 'update'])->name('donor.profile.update');
});
