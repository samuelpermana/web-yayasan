<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\DepositMaster;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class HomeController2 extends Controller
{
    public function index(Request $request)
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
            // Add net income to the initial value so balance calculation includes it
            $retainedEarnings->setAttribute('nilai_awal', $retainedEarnings->getAttribute('nilai_awal') + $netIncome);
        } else {
            $equities->push(new Account([
                'name'    => 'Laba Ditahan',
                'type'    => 'Equity',
                'nilai_awal' => $netIncome,
            ]));
        }

        // Hitung total
        $totalAssets      = $assets->sum->balance;
        $totalLiabilities = $liabilities->sum->balance;
        $totalEquity      = $equities->sum->balance;
        $balanceCheck     = $totalAssets - ($totalLiabilities + $totalEquity);

        // Apply filters to transactions
        $transactionsQuery = Transaction::with(['debitAccount', 'creditAccount', 'depositMaster']);
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $transactionsQuery->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $transactionsQuery->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        // Filter by description
        if ($request->filled('description')) {
            $transactionsQuery->where('description', 'like', '%' . $request->description . '%');
        }
        
        // Filter by debit account
        if ($request->filled('debit_account_id')) {
            $transactionsQuery->where('debit_account_id', $request->debit_account_id);
        }
        
        // Filter by credit account
        if ($request->filled('credit_account_id')) {
            $transactionsQuery->where('credit_account_id', $request->credit_account_id);
        }

        // Get paginated filtered transactions (15 per page) - sorted by ID ascending (oldest first)
        $transactions = $transactionsQuery->orderBy('id', 'asc')->paginate(15);

        // Keep track of current filters for pagination links
        $transactions->appends($request->only(['date_from', 'date_to', 'description', 'debit_account_id', 'credit_account_id']));

        // For dashboard display, we'll use the paginated results
        $recentTransactions = $transactions;

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
            'filters'            => $request->only(['date_from', 'date_to', 'description', 'debit_account_id', 'credit_account_id']),
        ]);
    }

    public function export(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'description', 'debit_account_id', 'credit_account_id']);
        
        // Create filename with filter info
        $filename = 'transactions_' . date('Y-m-d_H-i-s');
        if (!empty(array_filter($filters))) {
            $filename .= '_filtered';
        }
        $filename .= '.xlsx';
        
        return Excel::download(new TransactionExport($filters), $filename);
    }
}
