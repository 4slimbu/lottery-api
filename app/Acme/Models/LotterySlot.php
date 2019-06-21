<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class LotterySlot extends Model
{
    protected $table = 'lottery_slots';

    protected $fillable = [
        'slot_ref', 'start_time', 'end_time', 'has_winner', 'total_participants', 'entry_fee',
        'total_amount', 'result', 'status'
        ];

    protected $casts = [
        'result' => 'array'
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class)
//            ->withPivot('lottery_slot_id', 'lottery_number', 'lottery_winner_type_id', 'won_amount', 'service_charge')->orderBy('lottery_winner_type_id', 'DESC');
            ->withPivot('lottery_slot_id', 'lottery_number', 'lottery_winner_type_id', 'won_amount', 'service_charge')->orderBy('created_at', 'DESC');
    }

    public function winners()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('lottery_number', 'lottery_winner_type_id', 'won_amount', 'service_charge')->where('lottery_winner_type_id', '!=', null);
    }

    public function scopeFilter($query, $params)
    {
        // Filter using slot ref
        if (!empty($params['slot_ref'])) {
            $query = $query->where('slot_ref', 'LIKE', '%' . $params['slot_ref'] . '%');
        }

        // Filter using has_winner
        if (!empty($params['has_winner'])) {
            $has_winner = '';

            if (strpos('yes', strtolower($params['has_winner'])) === 0) {
                if (empty($has_winner)) {
                    $has_winner = 1;
                }
            }

            if (strpos('no', strtolower($params['has_winner'])) === 0) {
                if (empty($has_winner)) {
                    $has_winner = 0;
                }
            }

            if ($has_winner === 1 || $has_winner === 0) {
                $query = $query->where('has_winner', $has_winner);
            }
        }

        // Filter using total participants in the range of -5 to +5
        if (!empty($params['total_participants'])) {
            $query = $query->where('total_participants', '>', $params['total_participants'] - 5)
                ->where('total_participants', '<', $params['total_participants'] + 5);
        }

        // Filter using total amount in the range of -50 to +50
        if (!empty($params['total_amount'])) {
            $query = $query->where('total_amount', '>', $params['total_amount'] - 50)
                ->where('total_amount', '<', $params['total_amount'] + 50);
        }

        // Filter using result
        if (!empty($params['result'])) {

            $d = $params['result'];
            $r = array();

            $queryString = '';
            for ($i = 0; $i < strlen($params['result']); $i++) {
                $str = substr($d, $i, 1);
                $queryString .= '%' . $str . '%';
            }

            $query = $query->where('result', 'LIKE', $queryString);
        }

        // Filter using status
        if (!empty($params['status'])) {
            $status = '';

            if (strpos('active', strtolower($params['status'])) === 0) {
                if (empty($status)) {
                    $status = 1;
                }
            }

            if (strpos('inactive', strtolower($params['status'])) === 0) {
                if (empty($status)) {
                    $status = 0;
                }
            }

            if ($status === 1 || $status === 0) {
                $query = $query->where('status', $status);
            }
        }

        // Order by
        if (!empty($params['orderBy'])) {
            $query = $query->orderBy($params['orderBy'], isset($params['ascending']) && $params['ascending'] === 'true' ? 'ASC' : 'DESC');
        } else {
            $query = $query->orderBy('id', 'DESC');
        }

        return $query;
    }

}
