<?php

namespace App\Acme\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $seo = [
            'id' => (integer)$this->id,
            'page_id' => (integer)$this->page_id,
            'meta_title' => (string)$this->meta_title,
            'meta_description' => (string)$this->meta_description,
            'og_title' => (string)$this->og_title,
            'og_description' => (string)$this->og_description,
            'og_image' => (string)$this->og_image,
            'twitter_title' => (string)$this->twitter_title,
            'twitter_description' => (string)$this->twitter_description,
            'twitter_image' => (string)$this->twitter_image,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];

        return $seo;
    }

}