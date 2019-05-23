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
            'first_name' => 'string|required',
            'last_name' => 'string',
            'email' => 'string|required',
            'account_id' => 'integer|required',
            'new_password' => 'string|nullable',
        ];
    }
}