<?php

namespace App\Acme\Resources;

use App\Acme\Models\Comment;
use App\Acme\Resources\Core\CategoryResource;
use App\Acme\Resources\Core\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'user_id' => (integer)$this->user_id,
            'title' => (string)$this->post_title,
            'body' => (string)$this->post_body,
            'created_at' => (string)$this->created_at,
            'expire_at'=> (string)$this->expire_at,
            'author' => new PostUserResource($this->user),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'postImages' => MediaResource::collection($this->whenLoaded('media')),
        ];

        if ($this->user_id === auth()->user()->id) {
            $post['postComments'] = CommentResource::collection($this->comments);
        } else {
            $post['postComments'] = CommentResource::collection(($this->myComments));
        }
        return $post;
    }

}