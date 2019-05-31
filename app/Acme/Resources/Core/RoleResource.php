<?php

namespace App\Acme\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'label' => (string)$this->label,
            'permissions' => CorePermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
