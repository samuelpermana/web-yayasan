<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::all();
        $selectedAccount = null;
        $transactions = collect();
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $accountId = $request->input('account_id');

        if ($accountId && $startDate && $endDate) {
            $selectedAccount = Account::find($accountId);
            if ($selectedAccount) {
                $transactions = Transaction::with(['debitAccount', 'creditAccount'])
                    ->where(function($q) use ($accountId) {
                        $q->where('debit_account_id', $accountId)
                          ->orWhere('credit_account_id', $accountId);
                    })
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->orderBy('transaction_date')
                    ->get();
            }
        }

        return view('accounts', compact('accounts', 'selectedAccount', 'transactions', 'startDate', 'endDate'));
    }
}
