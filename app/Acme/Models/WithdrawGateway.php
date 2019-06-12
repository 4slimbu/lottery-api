<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawGateway extends Model
{
    protected $table = 'withdraw_gateway';

    protected $fillable = [
        'user_id', 'gateway', 'gateway_username'
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
