<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $fillable = [
        'currency', 'value_in_app_coin'
    ];

    public function scopeFilter($query, $params)
    {
        return $query;
    }
}
