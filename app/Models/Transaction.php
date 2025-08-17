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
        'paid_to_source',
        'id_deposit_master',
        'type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relasi ke Account
    public function account()
    {
        return $this->belongsTo(Account::class, 'paid_to_source');
    }

    // Relasi ke DepositMaster
    public function depositMaster()
    {
        return $this->belongsTo(DepositMaster::class, 'id_deposit_master');
    }
}
