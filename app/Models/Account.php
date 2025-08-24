<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    
    // Allow custom IDs (account numbers)
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'name',
        'description',
        'type',
        'nilai_awal',
    ];

    protected $casts = [
        'nilai_awal' => 'decimal:2',
    ];

    // Semua transaksi dimana account ini jadi debit
    public function debitTransactions()
    {
        return $this->hasMany(Transaction::class, 'debit_account_id');
    }

    // Semua transaksi dimana account ini jadi credit
    public function creditTransactions()
    {
        return $this->hasMany(Transaction::class, 'credit_account_id');
    }

    // ✅ Accessor saldo akun
    public function getBalanceAttribute()
    {
        $totalDebit  = $this->debitTransactions->sum('amount');
        $totalCredit = $this->creditTransactions->sum('amount');

        switch ($this->type) {
            case 'Asset':
                return $this->nilai_awal + $totalDebit - $totalCredit;
            case 'Liability':
            case 'Equity':
                return $this->nilai_awal + $totalCredit - $totalDebit;
            default:
                return $this->nilai_awal;
        }
    }
}
