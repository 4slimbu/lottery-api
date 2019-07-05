<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'user_id', 'won', 'pending_withdraw', 'deposit'
    ];

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function scopeFilter($query, $params)
    {

        return $query;
    }
}
