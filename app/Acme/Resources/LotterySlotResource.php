<?php

namespace App\Acme\Resources;

use App\Acme\Resources\Core\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LotterySlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $participants = $this->whenLoaded('participants', function (){
            return $this->participants()->select('id', 'first_name', 'last_name', 'profile_pic')->get();
        });

        return [
            'id' => (integer)$this->id,
            'slot_ref' => (string)$this->slot_ref,
            'start_time' => (string)$this->start_time,
            'end_time' => (string)$this->end_time,
            'has_winner' => (string)$this->has_winner,
            'total_participants' => (string)$this->total_participants,
            'total_amount' => (string)$this->total_amount,
            'result' => (array)$this->result,
            'status' => (string)$this->status,
            'participants' => $participants
        ];
    }
}
