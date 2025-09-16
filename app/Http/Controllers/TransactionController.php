<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DepositMaster;
use App\Models\Account;
use Illuminate\Support\Str;

class TransactionController extends Controller
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

        return view('transaction', [
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

    
    public function store(Request $request)
    {
        // Validasi input
        $rules = [
            'transaction_date'      => 'required|date',
            'transaction_master_id' => 'required|exists:deposit_masters,id',
            'description'           => 'required|string',
            'amount'                => 'required|numeric|min:0',
            'credit_account_id'     => 'required|exists:accounts,id',
            'debit_account_id'      => 'required|exists:accounts,id',
            'paid_to_source'        => 'required|string',
            'role_area'             => 'required|in:mahad,yayasan', // validasi tambahan
        ];

        try {
            $validated = $request->validate($rules);

            // Buat transaction baru
            Transaction::create([
                'transaction_date'      => $validated['transaction_date'],
                'transaction_master_id' => $validated['transaction_master_id'],
                'description'           => $validated['description'],
                'amount'                => $validated['amount'],
                'credit_account_id'     => $validated['credit_account_id'],
                'debit_account_id'      => $validated['debit_account_id'],
                'paid_to_source'        => $validated['paid_to_source'], // pakai ini
                'role_area'             => $validated['role_area'], // simpan role_area
            ]);

            return redirect()->route('transaction.index')
                            ->with('success', 'Transaction created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
