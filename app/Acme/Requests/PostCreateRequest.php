<?php

namespace App\Acme\Requests;

class PostCreateRequest extends ApiRequest
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
            'post_title' => 'string|required',
            'post_body' => 'string|required',
            'location_id' => 'integer|required',
            'category_id' => 'integer|required',
            'post_images' => 'array|nullable',
            'post_images.*' => 'file|nullable',
            'selected_image' => 'integer|nullable',
            'expire_at' => 'string|nullable'
        ];
    }
}