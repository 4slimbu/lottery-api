<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LotterySlotUser extends Model
{
    protected $table = 'lottery_slot_user';

    protected $primaryKey = ['lottery_slot_id','user_id'];

    public $incrementing = false;

    protected $fillable = [
        'lottery_slot_id', 'user_id', 'lottery_number', 'lottery_winner_type_id', 'won_amount', 'service_charge', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'lottery_number' => 'array'
    ];

    public $timestamps = false;

    public function lotterySlot()
    {
        return $this->belongsTo(LotterySlot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $params)
    {
        return $query;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
