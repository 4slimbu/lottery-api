<?php

namespace App\Acme\Requests;

class PostGetRequest extends ApiRequest
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
            'query' => 'string|nullable',
            'limit' => 'numeric|nullable',
            'category' => 'numeric|nullable',
            'search' => 'string|nullable',
            'type' => 'string|nullable',
        ];
    }
}