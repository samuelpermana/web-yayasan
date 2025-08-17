<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/
// JSON output untuk API
Route::get('/dashboard', [DashboardController::class, 'index']);

// Halaman utama (welcome) pakai controller display()
Route::get('/', [DashboardController::class, 'display']);
