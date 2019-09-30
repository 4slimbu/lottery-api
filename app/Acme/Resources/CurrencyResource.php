<?php

namespace App\Acme\Resources;

use App\Acme\Models\Comment;
use App\Acme\Resources\Core\CategoryResource;
use App\Acme\Resources\Core\LocationResource;
use App\Acme\Traits\PermissionTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    use PermissionTrait;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currency = [
            'id' => (integer)$this->id,
            'currency' => (string)$this->currency,
            'value_in_bits' => (string)$this->value_in_bits,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];

        return $currency;
    }

}