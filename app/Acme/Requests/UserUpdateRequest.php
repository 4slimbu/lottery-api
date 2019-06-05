<?php

namespace App\Acme\Requests;

class UserUpdateRequest extends ApiRequest
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
            'first_name' => 'string',
            'last_name' => 'string',
            'account_id' => 'integer',
            'new_password' => 'string|nullable',
            'is_active' => 'integer',
            'user_ids' => 'array'
        ];
    }
}