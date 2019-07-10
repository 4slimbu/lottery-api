<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key', 'label', 'value', 'comment'
    ];

    public function scopeFilter($query, $params)
    {

        return $query;
    }
}
