<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMaster extends Model
{
    use HasFactory;

    protected $table = 'deposit_masters';

    protected $fillable = [
        'number',
        'description',
        'default_amount',
        'debit_account_id',
        'credit_account_id',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_deposit_master');
    }

    // Relasi ke akun debit
    public function debitAccount()
    {
        return $this->belongsTo(Account::class, 'debit_account_id');
    }

    // Relasi ke akun credit
    public function creditAccount()
    {
        return $this->belongsTo(Account::class, 'credit_account_id');
    }
}
