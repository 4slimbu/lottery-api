<?php

namespace App\Acme\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'label' => (string)$this->label,
            'city' => isset($this->suburb_name)?(string)$this->suburb_name:null,
            'state' => isset($this->state_code)?(string)$this->state_code:null,
            'state_location_id' => isset($this->state_location_id)?(string)$this->state_location_id:null,
            'state_name' => isset($this->state_name)?(string)$this->state_name:null,
            'country' => isset($this->country_code)?(string)$this->country_code:null,
            'postcode' => isset($this->post_code)?(string)$this->post_code:null,
            'type' => (string)$this->type,
        ];
    }
}
