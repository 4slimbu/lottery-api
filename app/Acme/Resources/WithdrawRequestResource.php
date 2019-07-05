<?php

namespace App\Acme\Resources;

use App\Acme\Resources\Core\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawRequestResource extends JsonResource
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
            'id' => (integer) $this->id,
            'user_id' => (integer)$this->user_id,
            'amount' => (string)$this->amount,
            'status' => (string)$this->status,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
