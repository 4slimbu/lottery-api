<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $table = 'withdraw_requests';

    protected $fillable = [
        'user_id', 'amount', 'status'
    ];

    public function scopeFilter($query, $params)
    {
        return $query;
    }
}
