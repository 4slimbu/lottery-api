<?php

namespace App\Acme\Resources;

use App\Acme\Resources\Core\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LotterySlotUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lottery_slot_id' => (integer)$this->lottery_slot_id,
            'user_id' => (integer)$this->user_id,
            'lottery_number' => (array)$this->lottery_number,
            'lottery_winner_type_id' => (integer)$this->lottery_winner_type_id,
            'won_amount' => (string)$this->won_amount,
            'service_charge' => (string)$this->service_charge,
        ];
    }
}
