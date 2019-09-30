<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $fillable = [
        'currency', 'value_in_bits'
    ];

    public function scopeFilter($query, $params)
    {
        return $query;
    }

    public function coinToBits($coin)
    {
        $coinModel = $this->where('currency', 'Coin')->first();

        return $coinModel->value_in_bits * $coin;
    }

    public function bitsToCoin($bits)
    {
        $coinModel = $this->where('currency', 'Coin')->first();

        return $bits / $coinModel->value_in_bits;
    }

    public function btcToBits($btc)
    {
        $btcModel = $this->where('currency', 'BTC')->first();

        return $btc * $btcModel->value_in_bits;
    }

    public function bitsToBtc($bits)
    {
        $btcModel = $this->where('currency', 'BTC')->first();

        return $bits / $btcModel->value_in_bits;
    }
}
