<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'user_id', 'withdrawable_amount', 'pending_withdraw_amount', 'usable_amount', 'total_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $params)
    {

        return $query;
    }
}
