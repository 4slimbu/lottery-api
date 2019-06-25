<?php

namespace App\Acme\Resources;

use App\Acme\Models\Comment;
use App\Acme\Resources\Core\CategoryResource;
use App\Acme\Resources\Core\LocationResource;
use App\Acme\Traits\PermissionTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'key' => (string)$this->key,
            'label' => (string)$this->label,
            'value' => (string)$this->value,
        ];

        if ($this->currentUserCan('updateSetting')) {
            $additionalValues = [
                'field' => (string)$this->field,
                'field_value'=> (string)$this->field_value,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];

            $post = array_merge($post, $additionalValues);
        }

        return $post;
    }

}