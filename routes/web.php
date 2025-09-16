<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositMasterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController2;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\AuthController;

// Login & Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
Route::get('/', [HomeController2::class, 'index'])->name('dashboard');
Route::get('/mahad', [HomeController2::class, 'dashboardMahad'])->name('dashboard.mahad');
Route::get('/yayasan', [HomeController2::class, 'dashboardYayasan'])->name('dashboard.yayasan');
Route::get('/export-transactions', [HomeController2::class, 'export'])->name('transactions.export');
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::post('/deposit/store', [DepositMasterController::class, 'store'])->name('deposit.store');
Route::delete('/deposit/{id}', [DepositMasterController::class, 'delete'])->name('deposit.delete');
Route::get('/journals', [JournalController::class, 'index'])->name('journal.index');
Route::get('/journals/{id}/edit', [JournalController::class, 'edit'])->name('journal.edit');
Route::put('/journals/{id}', [JournalController::class, 'update'])->name('journal.update');
Route::get('/coa', [CoaController::class, 'index'])->name('coa.index');
Route::post('/coa', [CoaController::class, 'store'])->name('coa.store');
Route::put('/coa/{id}', [CoaController::class, 'update'])->name('coa.update');
Route::delete('/coa/{id}', [CoaController::class, 'destroy'])->name('coa.destroy'); 
Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/accounts/{account}/transactions', [AccountController::class, 'transactions']);
Route::get('/deposit-masters/edit', [DepositMasterController::class, 'edit']);
Route::get('/deposit-masters', [DepositMasterController::class, 'index'])->name('dm.index');
Route::post('/deposit-masters', [DepositMasterController::class, 'store'])->name('dm.store');
Route::put('/deposit-masters/{id}', [DepositMasterController::class, 'update'])->name('dm.update');
Route::get('/deposit-masters/{id}', [DepositMasterController::class, 'edit'])->name('dm.edit');
Route::delete('/deposit-masters/{id}', [DepositMasterController::class, 'destroy'])->name('dm.destroy');
});

// User only
Route::middleware(['auth', 'role:user'])->group(function () {
Route::get('/user/dashboard', [HomeController2::class, 'index'])->name('user.dashboard');
Route::get('/user/export-transactions', [HomeController2::class, 'export'])->name('user.transactions.export');
Route::get('/user/coa', [CoaController::class, 'userIndex'])->name('user.coa'); 
});


Route::get('/contoh', function () {
    return view('contoh');
});