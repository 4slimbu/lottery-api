<?php

namespace App\Acme\Resources;

use App\Acme\Resources\Core\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'id' => (integer)$this->id,
            'user_id' => (string)$this->user_id,
            'full_name' => (string)$this->user->full_name,
            'won' => (string)$this->won,
            'pending_withdraw' => (string)$this->pending_withdraw,
            'deposit' => (string)$this->deposit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
