<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $table = 'wallet_transactions';

    protected $fillable = [
        'transaction_code', 'wallet_id', 'type', 'amount', 'service_charge'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function scopeFilter($query, $params)
    {
        return $query;
    }

}
