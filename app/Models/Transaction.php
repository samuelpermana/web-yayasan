<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'description',
        'amount',
        'transaction_date',
        'paid_to_source',
        'id_deposit_master',
        'debit_account_id',
        'credit_account_id',
        'role_area', // ditambahkan
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    // Relasi ke Account
    public function debitAccount()
    {
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    public function creditAccount()
    {
        return $this->belongsTo(Account::class, 'credit_account_id');
    }

    // Relasi ke DepositMaster
    public function depositMaster()
    {
        return $this->belongsTo(DepositMaster::class, 'id_deposit_master');
    }
}
