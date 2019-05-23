<?php

namespace App\Acme\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class CoreAccountTypeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (integer)$this->id,
            'name' => (string)$this->name,
        ];
    }
}