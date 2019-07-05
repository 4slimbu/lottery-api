<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [
        'user_id', 'wallet_id', 'amount', 'charge_code', 'status'
    ];


    public function scopeFilter($query, $params)
    {

        return $query;
    }
}
