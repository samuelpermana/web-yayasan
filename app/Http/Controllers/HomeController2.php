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
    // =======================
    // 1. TOTAL (GLOBAL)
    // =======================
    public function index(Request $request)
    {
        $totalTransactions = Transaction::count();

        $totalIncome  = Transaction::whereHas('creditAccount', fn($q) => $q->where('type', 'Income'))->sum('amount');
        $totalExpense = Transaction::whereHas('debitAccount', fn($q) => $q->where('type', 'Expense'))->sum('amount');
        $netIncome    = $totalIncome - $totalExpense;

        $accounts = Account::with(['debitTransactions', 'creditTransactions'])->get();

        $assets      = $accounts->where('type', 'Asset');
        $liabilities = $accounts->where('type', 'Liability');
        $equities    = $accounts->where('type', 'Equity');

        // Laba Ditahan
        $retained = $equities->firstWhere('name', 'Laba Ditahan');
        if ($retained) {
            $retained->setAttribute('nilai_awal', $retained->getAttribute('nilai_awal') + $netIncome);
        } else {
            $equities->push(new Account([
                'name'       => 'Laba Ditahan',
                'type'       => 'Equity',
                'nilai_awal' => $netIncome,
            ]));
        }

        $totalAssets      = $assets->sum->balance;
        $totalLiabilities = $liabilities->sum->balance;
        $totalEquity      = $equities->sum->balance;
        $balanceCheck     = $totalAssets - ($totalLiabilities + $totalEquity);

        // Transaksi recent
        $transactions = Transaction::with(['debitAccount', 'creditAccount', 'depositMaster'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        $deposit_masters = DepositMaster::all();

        $data = [
            'total_transactions' => $totalTransactions,
            'balance'            => $totalAssets,
            'total_income'       => $totalIncome,
            'total_expenses'     => $totalExpense,
            'net_income'         => $netIncome,
            'total_assets'       => $totalAssets,
            'total_liabilities'  => $totalLiabilities,
            'total_equity'       => $totalEquity,
            'balance_check'      => $balanceCheck,
            'transactions'       => $transactions,
            'accounts'           => $accounts,
            'deposit_masters'    => $deposit_masters,
        ];

        // Debug JSON
        // return response()->json($data);

        return view('dashboard', $data);
    }

    // =======================
    // 2. MAHAD
    // =======================
    public function dashboardMahad(Request $request)
    {
        $role = 'mahad';

        $accounts = Account::where('role_area', $role)->with(['debitTransactions', 'creditTransactions'])->get();

        $assets      = $accounts->where('type', 'Asset');
        $liabilities = $accounts->where('type', 'Liability');
        $equities    = $accounts->where('type', 'Equity');

        $income  = Transaction::whereHas('creditAccount', fn($q) => $q->where('type', 'Income')->where('role_area', $role))->sum('amount');
        $expense = Transaction::whereHas('debitAccount', fn($q) => $q->where('type', 'Expense')->where('role_area', $role))->sum('amount');
        $net     = $income - $expense;

        $retained = $equities->firstWhere('name', 'Laba Ditahan');
        if ($retained) {
            $retained->setAttribute('nilai_awal', $retained->getAttribute('nilai_awal') + $net);
        } else {
            $equities->push(new Account([
                'name'       => 'Laba Ditahan',
                'type'       => 'Equity',
                'role_area'  => $role,
                'nilai_awal' => $net,
            ]));
        }

        $totalAssets      = $assets->sum->balance;
        $totalLiabilities = $liabilities->sum->balance;
        $totalEquity      = $equities->sum->balance;
        $balanceCheck     = $totalAssets - ($totalLiabilities + $totalEquity);

        // 🔹 Hitung total transaksi (supaya tidak undefined di partial stats)
        $totalTransactions = Transaction::where(function($q) use ($role) {
            $q->whereHas('debitAccount', fn($qq) => $qq->where('role_area', $role))
            ->orWhereHas('creditAccount', fn($qq) => $qq->where('role_area', $role));
        })->count();

        // 🔹 Tambahkan filter transaksi
        $transactions = Transaction::with(['debitAccount', 'creditAccount', 'depositMaster'])
            ->where(function ($q) use ($role) {
                $q->whereHas('debitAccount', fn($qq) => $qq->where('role_area', $role))
                ->orWhereHas('creditAccount', fn($qq) => $qq->where('role_area', $role));
            })
            ->when($request->date_from, fn($q) => $q->whereDate('transaction_date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('transaction_date', '<=', $request->date_to))
            ->when($request->description, fn($q) => $q->where('description', 'like', "%{$request->description}%"))
            ->when($request->debit_account_id, fn($q) => $q->where('debit_account_id', $request->debit_account_id))
            ->when($request->credit_account_id, fn($q) => $q->where('credit_account_id', $request->credit_account_id))
            ->orderBy('id', 'desc')
            ->paginate(15);

        $data = [
            'total_transactions' => $totalTransactions, // ✅ ini penting
            'total_income'       => $income,
            'total_expenses'     => $expense,
            'net_income'         => $net,
            'total_assets'       => $totalAssets,
            'total_liabilities'  => $totalLiabilities,
            'total_equity'       => $totalEquity,
            'balance_check'      => $balanceCheck,
            'transactions'       => $transactions,
            'accounts'           => $accounts,
        ];

        return view('dashboard-mahad', $data);
    }

    // =======================
    // 3. YAYASAN
    // =======================
    public function dashboardYayasan(Request $request)
    {
        $role = 'yayasan';

        $accounts = Account::where('role_area', $role)->with(['debitTransactions', 'creditTransactions'])->get();

        $assets      = $accounts->where('type', 'Asset');
        $liabilities = $accounts->where('type', 'Liability');
        $equities    = $accounts->where('type', 'Equity');

        $income  = Transaction::whereHas('creditAccount', fn($q) => $q->where('type', 'Income')->where('role_area', $role))->sum('amount');
        $expense = Transaction::whereHas('debitAccount', fn($q) => $q->where('type', 'Expense')->where('role_area', $role))->sum('amount');
        $net     = $income - $expense;

        $retained = $equities->firstWhere('name', 'Laba Ditahan');
        if ($retained) {
            $retained->setAttribute('nilai_awal', $retained->getAttribute('nilai_awal') + $net);
        } else {
            $equities->push(new Account([
                'name'       => 'Laba Ditahan',
                'type'       => 'Equity',
                'role_area'  => $role,
                'nilai_awal' => $net,
            ]));
        }

        $totalAssets      = $assets->sum->balance;
        $totalLiabilities = $liabilities->sum->balance;
        $totalEquity      = $equities->sum->balance;
        $balanceCheck     = $totalAssets - ($totalLiabilities + $totalEquity);

        // 🔹 Hitung total transaksi (supaya tidak undefined di partial stats)
        $totalTransactions = Transaction::where(function($q) use ($role) {
            $q->whereHas('debitAccount', fn($qq) => $qq->where('role_area', $role))
            ->orWhereHas('creditAccount', fn($qq) => $qq->where('role_area', $role));
        })->count();

        // 🔹 Tambahkan filter transaksi
        $transactions = Transaction::with(['debitAccount', 'creditAccount', 'depositMaster'])
            ->where(function ($q) use ($role) {
                $q->whereHas('debitAccount', fn($qq) => $qq->where('role_area', $role))
                ->orWhereHas('creditAccount', fn($qq) => $qq->where('role_area', $role));
            })
            ->when($request->date_from, fn($q) => $q->whereDate('transaction_date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('transaction_date', '<=', $request->date_to))
            ->when($request->description, fn($q) => $q->where('description', 'like', "%{$request->description}%"))
            ->when($request->debit_account_id, fn($q) => $q->where('debit_account_id', $request->debit_account_id))
            ->when($request->credit_account_id, fn($q) => $q->where('credit_account_id', $request->credit_account_id))
            ->orderBy('id', 'desc')
            ->paginate(15);

        $data = [
            'total_transactions' => $totalTransactions, // ✅ ini penting
            'total_income'       => $income,
            'total_expenses'     => $expense,
            'net_income'         => $net,
            'total_assets'       => $totalAssets,
            'total_liabilities'  => $totalLiabilities,
            'total_equity'       => $totalEquity,
            'balance_check'      => $balanceCheck,
            'transactions'       => $transactions,
            'accounts'           => $accounts,
        ];


        // Debug JSON
        // return response()->json($data);

        return view('dashboard-yayasan', $data);
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
