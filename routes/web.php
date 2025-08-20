<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositMasterController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\HomeController2;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CoaController;

Route::get('/', [HomeController2::class, 'index'])->name('dashboard');

// Transaction
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

// Deposit Master
Route::post('/deposit/store', [DepositMasterController::class, 'store'])->name('deposit.store');
Route::delete('/deposit/{id}', [DepositMasterController::class, 'delete'])->name('deposit.delete');

// Journal
// Journal
Route::get('/journals', [JournalController::class, 'index'])->name('journal.index'); 
Route::get('/coa', [CoaController::class, 'index'])->name('coa.index'); 

// Accounts
Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/accounts/{account}/transactions', [AccountController::class, 'transactions']);


Route::get('/deposit-masters/edit', [DepositMasterController::class, 'edit']);

Route::get('/deposit-masters', [DepositMasterController::class, 'index'])->name('dm.index');
Route::post('/deposit-masters', [DepositMasterController::class, 'store'])->name('dm.store');
Route::put('/deposit-masters/{id}', [DepositMasterController::class, 'update'])->name('dm.update');
Route::get('/deposit-masters/{id}', [DepositMasterController::class, 'edit'])->name('dm.edit');
Route::delete('/deposit-masters/{id}', [DepositMasterController::class, 'destroy'])->name('dm.destroy');
