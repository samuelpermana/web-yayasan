<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Transaction::with(['debitAccount', 'creditAccount'])->get();

        return view('journal', compact('journals'));
    }
}
