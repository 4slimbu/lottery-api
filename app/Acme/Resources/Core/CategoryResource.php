<?php

namespace App\Acme\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => (string)$this->name,
            'icon' => (string)$this->icon,
            'description' => (string)$this->description,
            'sort_order' => (integer)$this->sort_order,
        ];
    }
}
