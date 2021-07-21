<?php

namespace App\Acme\Requests;

class SeoUpdateRequest extends ApiRequest
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
            'page_id' => 'required|numeric',
            'meta_title' => 'string|nullable',
            'meta_description' => 'string|nullable',
            'og_title' => 'string|nullable',
            'og_description' => 'string|nullable',
            'og_image' => 'string|nullable',
            'twitter_title' => 'string|nullable',
            'twitter_description' => 'string|nullable',
            'twitter_image' => 'string|nullable',
        ];
    }
}