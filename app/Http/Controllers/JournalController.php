<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Transaction::with(['debitAccount', 'creditAccount'])->get();
        return view('journal', compact('journals'));
    }

    // ✅ Menampilkan form edit
    public function edit($id)
    {
        $journal = Transaction::findOrFail($id);
        $accounts = Account::all(); // untuk pilihan debit & kredit
        return view('journal.edit', compact('journal', 'accounts'));
    }

    // ✅ Proses update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'description'       => 'required|string|max:255',
            'amount'            => 'required|numeric|min:0',
            'debit_account_id'  => 'required|exists:accounts,id',
            'credit_account_id' => 'required|exists:accounts,id',
        ]);

        $journal = Transaction::findOrFail($id);
        $journal->update([
            'description'       => $request->description,
            'amount'            => $request->amount,
            'debit_account_id'  => $request->debit_account_id,
            'credit_account_id' => $request->credit_account_id,
        ]);

        return redirect()->route('journal.index')->with('success', 'Journal entry updated successfully!');
    }
}
