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
            'username' => (string)$this->user->username,
            'nickname' => (string)$this->user->nickname,
            'full_name' => (string)$this->user->full_name,
            'lottery_number' => (array)$this->lottery_number,
            'lottery_winner_type_id' => (integer)$this->lottery_winner_type_id,
            'won_amount' => (string)$this->won_amount,
            'service_charge' => (string)$this->service_charge,
            'lottery_slot' => new LotterySlotResource($this->whenLoaded('lotterySlot')),
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
