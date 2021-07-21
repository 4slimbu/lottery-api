<?php

namespace App\Acme\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $post = [
            'id' => (integer)$this->id,
            'key' => (string)$this->key,
            'label' => (string)$this->label,
            'value' => (string)$this->value,
            'comment' => (string)$this->comment
        ];

        return $post;
    }

}