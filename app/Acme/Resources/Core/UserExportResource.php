<?php

namespace App\Acme\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class UserExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $profilePicture = url('/storage/placeholder/profile_picture.png');
        if ($this->getFirstMedia('profile')) {
            $profilePicture = $this->getFirstMedia('profile')->getFullUrl('thumb');
        }

        return [
            'username' => (string)$this->username,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'contact_number' => (string)$this->contact_number,
            'email' => (string)$this->email,
            'created_at' => (string)$this->created_at
        ];
    }
}
