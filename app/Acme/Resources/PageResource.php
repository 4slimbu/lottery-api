<?php

namespace App\Acme\Resources;

use App\Acme\Models\Comment;
use App\Acme\Resources\Core\CategoryResource;
use App\Acme\Resources\Core\LocationResource;
use App\Acme\Traits\PermissionTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $page = [
            'id' => (integer)$this->id,
            'title' => (string)$this->title,
            'slug' => (string)$this->slug,
            'content' => (string)$this->content,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ];

        return $page;
    }

}