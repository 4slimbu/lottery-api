<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class LotterySlot extends Model
{
    protected $table = 'lottery_slots';

    protected $fillable = [
        'slot_ref', 'start_time', 'end_time', 'has_winner', 'total_participants',
        'total_amount', 'result', 'status'
        ];

    protected $casts = [
        'result' => 'array'
    ];

    public function scopeFilter($query, $params)
    {
        if (!empty($params['orderBy'])) {
            $query = $query->orderBy($params['orderBy'], isset($params['ascending']) && $params['ascending'] === 'true' ? 'ASC' : 'DESC');
        } else {
            $query = $query->orderBy('id', 'DESC');
        }

        return $query;
    }

}
