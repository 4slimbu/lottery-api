<?php

namespace App\Acme\Resources;

use App\Acme\Resources\Core\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
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
            'wallet_id' => (string)$this->wallet_id,
            'wallet_transaction_id' => (string)$this->wallet_transaction_id,
            'amount' => (string)$this->amount,
            'currency' => (string)$this->currency,
            'status' => (string)$this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
