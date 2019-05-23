<?php

namespace App\Acme\Requests;

class PostUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_title' => 'string',
            'post_body' => 'string',
            'location_id' => 'integer',
            'category_id' => 'integer',
            'post_images' => 'array',
            'selected_image' => 'integer|nullable',
            'images_to_remove' => 'array|nullable',
            'expire_at' => 'string|nullable'
        ];
    }
}