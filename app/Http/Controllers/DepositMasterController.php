<?php

namespace App\Http\Controllers;

use App\Models\DepositMaster;
use App\Models\Account;
use Illuminate\Http\Request;

class DepositMasterController extends Controller
{
    public function index()
    {
        $deposit_masters  = DepositMaster::all();
        $accounts = Account::all();

        return view('deposit_masters.index', compact('deposit_masters', 'accounts'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('deposit_masters.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'debit_account_id' => 'required|exists:accounts,id',
            'credit_account_id' => 'required|exists:accounts,id',
            'default_amount' => 'required|numeric',
        ]);

        DepositMaster::create($request->all());

        return redirect()->route('dm.index')->with('success', 'Deposit Master created successfully.');
    }

    public function edit($id)
    {
        $deposit = DepositMaster::findOrFail($id);
        $accounts = Account::all();
        return view('deposit_masters.edit', compact('deposit', 'accounts'));
    }
public function update(Request $request, $id)
{
    try {
        $request->validate([
            'debit_account_id' => 'required|exists:accounts,id',
            'credit_account_id' => 'required|exists:accounts,id',
            'default_amount' => 'required|numeric',
        ]);

        $depositMaster = DepositMaster::findOrFail($id);
        $depositMaster->update($request->all());

        // kalau berhasil
        return redirect()
            ->route('dm.index')
            ->with('success', 'Deposit Master updated successfully.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // kalau gagal validasi
        return response()->json([
            'status' => 'validation_error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // kalau error lain
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($id)
    {
        $depositMaster = DepositMaster::findOrFail($id);
        $depositMaster->delete();

        return redirect()->route('dm.index')->with('success', 'Deposit Master deleted successfully.');
    }
}
