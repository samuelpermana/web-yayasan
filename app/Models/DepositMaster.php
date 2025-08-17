<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMaster extends Model
{
    use HasFactory;

    protected $table = 'deposit_master';

    protected $fillable = [
        'description',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_deposit_master');
    }
}
