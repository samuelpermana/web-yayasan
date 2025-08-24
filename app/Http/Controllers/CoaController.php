<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class CoaController extends Controller
{
    public function index(Request $request)
    {
        $query = Account::query();
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%');
            });
        }
        
        $accounts = $query->orderBy('id', 'asc')->paginate(15);
        
        // Preserve search query in pagination links
        $accounts->appends($request->only(['search']));
        
        return view('coa', compact('accounts'));
    }

    public function userIndex(Request $request)
    {
        $query = Account::query();
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%');
            });
        }
        
        $accounts = $query->orderBy('id', 'asc')->paginate(15);
        
        // Preserve search query in pagination links
        $accounts->appends($request->only(['search']));
        
        return view('user.coa', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|integer|unique:accounts,id',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:Asset,Liability,Equity,Income,Expense',
            'description' => 'nullable|string|max:500',
            'initial_value' => 'nullable|numeric|min:0',
        ]);

        Account::create([
            'id' => $request->account_number,
            'name' => $request->account_name,
            'type' => $request->account_type,
            'description' => $request->description,
            'nilai_awal' => $request->initial_value ?? 0,
        ]);

        return redirect()->route('coa.index')->with('success', 'Account created successfully!');
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $request->validate([
            'account_number' => 'required|integer|unique:accounts,id,' . $id,
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|in:Asset,Liability,Equity,Income,Expense',
            'description' => 'nullable|string|max:500',
            'initial_value' => 'nullable|numeric|min:0',
        ]);

        // If account number changed, we need to handle it carefully
        if ($request->account_number != $id) {
            // Check if new account number is available
            if (Account::where('id', $request->account_number)->exists()) {
                return redirect()->back()->withErrors(['account_number' => 'Account number already exists.']);
            }
            
            // Create new account with new ID and delete old one
            $newAccount = Account::create([
                'id' => $request->account_number,
                'name' => $request->account_name,
                'type' => $request->account_type,
                'description' => $request->description,
                'nilai_awal' => $request->initial_value ?? 0,
            ]);
            
            // Update any transactions that reference the old account
            DB::table('transactions')->where('debit_account_id', $id)->update(['debit_account_id' => $request->account_number]);
            DB::table('transactions')->where('credit_account_id', $id)->update(['credit_account_id' => $request->account_number]);
            
            // Delete old account
            $account->delete();
        } else {
            // Update existing account
            $account->update([
                'name' => $request->account_name,
                'type' => $request->account_type,
                'description' => $request->description,
                'nilai_awal' => $request->initial_value ?? 0,
            ]);
        }

        return redirect()->route('coa.index')->with('success', 'Account updated successfully!');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        // Check if account is used in any transactions
        $debitTransactions = DB::table('transactions')->where('debit_account_id', $id)->count();
        $creditTransactions = DB::table('transactions')->where('credit_account_id', $id)->count();

        if ($debitTransactions > 0 || $creditTransactions > 0) {
            return redirect()->route('coa.index')->withErrors(['delete' => 'Cannot delete account. It is used in ' . ($debitTransactions + $creditTransactions) . ' transaction(s).']);
        }

        $account->delete();

        return redirect()->route('coa.index')->with('success', 'Account deleted successfully!');
    }
}
