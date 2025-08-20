<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\DepositMaster;

class HomeController2 extends Controller
{
    public function index()
    {
        $totalTransactions = Transaction::count();

        // Total Income & Expense
        $totalIncome = Transaction::whereHas('creditAccount', fn($q) => $q->where('type', 'Income'))
            ->sum('amount');
        $totalExpense = Transaction::whereHas('debitAccount', fn($q) => $q->where('type', 'Expense'))
            ->sum('amount');
        $netIncome = $totalIncome - $totalExpense;

        // Ambil semua akun dengan transaksi
        $accounts = Account::with(['debitTransactions', 'creditTransactions'])->get();

        // Filter berdasarkan type
        $assets      = $accounts->where('type', 'Asset');
        $liabilities = $accounts->where('type', 'Liability');
        $equities    = $accounts->where('type', 'Equity');

        // Tambahkan Net Income ke Retained Earnings
        $retainedEarnings = $equities->firstWhere('name', 'Laba Ditahan');
        if ($retainedEarnings) {
            $retainedEarnings->balance += $netIncome;
        } else {
            $equities->push(new Account([
                'name'    => 'Laba Ditahan',
                'type'    => 'Equity',
                'balance' => $netIncome,
            ]));
        }

        // Hitung total
        $totalAssets      = $assets->sum->balance;
        $totalLiabilities = $liabilities->sum->balance;
        $totalEquity      = $equities->sum->balance;
        $balanceCheck     = $totalAssets - ($totalLiabilities + $totalEquity);

        // Semua transaksi
        $transactions = Transaction::with(['debitAccount', 'creditAccount', 'depositMaster'])
            ->latest()
            ->get();

        // 3 transaksi terbaru
        $recentTransactions = $transactions->take(3);

        // Semua deposit master
        $deposit_masters = DepositMaster::all();

        return view('dashboard', [
            'total_transactions' => $totalTransactions,
            'balance'            => $totalAssets, // alias total aset
            'total_income'       => $totalIncome,
            'total_expenses'     => $totalExpense,
            'net_income'         => $netIncome,
            'assets'             => $assets,
            'liabilities'        => $liabilities,
            'equities'           => $equities,
            'transactions'       => $transactions,
            'recentTransactions' => $recentTransactions,
            'accounts'           => $accounts,
            'deposit_masters'    => $deposit_masters,
            'total_assets'       => $totalAssets,
            'total_liabilities'  => $totalLiabilities,
            'total_equity'       => $totalEquity,
            'balance_check'      => $balanceCheck,
        ]);
    }
}
