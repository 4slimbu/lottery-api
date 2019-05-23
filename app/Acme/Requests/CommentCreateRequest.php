<?php

namespace App\Acme\Requests;

class CommentCreateRequest extends ApiRequest
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
            'post_id' => 'integer|required',
            'parent_id' => 'integer',
            'comment_body' => 'string|required',
        ];
    }
}