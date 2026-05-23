<?php

use App\Http\Controllers\Shared\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

require __DIR__ . '/admin.php';
require __DIR__ . '/donor.php';
require __DIR__ . '/requester.php';
require __DIR__ . '/auth.php';
