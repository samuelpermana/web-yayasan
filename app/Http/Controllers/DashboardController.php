<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Jumlah semua transaksi
        $totalTransactions = Transaction::count();

        // 2. Balance total terakhir
        $totalIncome = Transaction::where('type', 'Income')->sum('amount');
        $totalExpense = Transaction::where('type', 'Expense')->sum('amount');
        $initialBalance = Account::sum('nilai_awal');
        $balance = $initialBalance + $totalIncome - $totalExpense;

        // 5. Semua transactions yang ada (data lengkap + relasi)
        $transactions = Transaction::with(['account', 'depositMaster'])->get();

        // 6. Semua Accounts yang ada (data lengkap)
        $accounts = Account::all();

        return response()->json([
            'total_transactions' => $totalTransactions,
            'balance'            => $balance,
            'total_income'       => $totalIncome,
            'total_expenses'     => $totalExpense,
            'transactions'       => $transactions,
            'accounts'           => $accounts,
        ]);
    }
    public function display()
    {
        $totalTransactions = Transaction::count();

        $totalIncome = Transaction::where('type', 'Income')->sum('amount');
        $totalExpense = Transaction::where('type', 'Expense')->sum('amount');
        $initialBalance = Account::sum('nilai_awal');
        $balance = $initialBalance + $totalIncome - $totalExpense;

        // semua transaksi
        $transactions = Transaction::with(['account', 'depositMaster'])
            ->latest()
            ->get();

        // hanya 3 transaksi terbaru
        $recentTransactions = Transaction::with(['account', 'depositMaster'])
            ->latest()
            ->take(3)
            ->get();

        $accounts = Account::all();

        return view('welcome', [
            'total_transactions' => $totalTransactions,
            'balance'            => $balance,
            'total_income'       => $totalIncome,
            'total_expenses'     => $totalExpense,
            'transactions'       => $transactions,
            'recentTransactions' => $recentTransactions,
            'accounts'           => $accounts,
        ]);
    }

}
