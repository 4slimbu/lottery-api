<?php

namespace App\Acme\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'full_name' => (string)$this->full_name,
            'gender' => (string)$this->gender,
            'contact_number' => (string)$this->contact_number,
            'email' => (string)$this->email,
            'verified' => (bool)$this->verified,
            'profile_pic' => (string)$this->profile_pic,
            'is_active' => (bool)$this->is_active,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
