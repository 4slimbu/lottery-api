<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [
        'user_id', 'wallet_id', 'wallet_transaction_id', 'amount', 'charge_code', 'status'
    ];

    public function walletTransaction()
    {
        return $this->belongsTo(WalletTransaction::class);
    }

    public function scopeFilter($query, $params)
    {

        return $query;
    }
}
