<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $table = 'wallet_transactions';

    protected $fillable = [
        'transaction_code', 'wallet_id', 'type', 'currency', 'amount'
    ];

    public function scopeFilter($query, $params)
    {

        return $query;
    }
}
