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
        $post = [
            'id' => (integer)$this->id,
            'currency' => (string)$this->currency,
            'value_in_app_coin' => (string)$this->value_in_app_coin,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];

        return $post;
    }

}