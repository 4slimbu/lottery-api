<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Attribute extends Resource
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
            'id' => $this->id,
            'attribute_type' => $this->attribute_type,
            'name' => $this->name,
        ];
    }
}
