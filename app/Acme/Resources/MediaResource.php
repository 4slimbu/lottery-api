<?php

namespace App\Acme\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'is_primary' => (boolean)$this->is_primary,
            'post_id' => (integer)$this->post_id,
            'user_id' => (integer)$this->user_id,
            'url' => (string)$this->url,
        ];
    }
}