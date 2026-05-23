<?php

use App\Http\Controllers\Donor\DonorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'donor'])->group(function () {
    Route::get('/donor/home', [DonorController::class, 'donorHome'])->name('donor.home');
    Route::get('/become-donor', [DonorController::class, 'create'])->name('donor.become');
    Route::post('/save-donor', [DonorController::class, 'store'])->name('donor.store');
    Route::get('/profile', [DonorController::class, 'profile'])->name('donor.profile');
    Route::get('/profile/edit', [DonorController::class, 'edit'])->name('donor.profile.edit');
    Route::post('/profile/update', [DonorController::class, 'update'])->name('donor.profile.update');
    Route::get('/toggle-status', [DonorController::class, 'toggleStatus'])->name('donor.status.toggle');
    Route::post('/toggle-availability', [DonorController::class, 'toggleAvailability'])->name('toggle.availability');
    Route::post('/upload-image', [DonorController::class, 'uploadImage'])->name('donor.image.upload');
});
