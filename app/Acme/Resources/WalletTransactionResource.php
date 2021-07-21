<?php

namespace App\Acme\Resources;

use App\Acme\Resources\Core\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
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
            'transaction_code' => (string)$this->transaction_code,
            'wallet_id' => (integer)$this->wallet_id,
            'type' => (string)$this->type,
            'amount' => (string)$this->amount,
            'deposit' => new DepositResource($this->whenLoaded('deposit')),
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
