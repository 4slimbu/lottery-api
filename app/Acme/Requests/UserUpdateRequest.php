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
            'username' => 'string',
            'first_name' => 'string',
            'last_name' => 'string|nullable',
            'password' => 'string|min:8|max:20',
            'gender' => 'string',
            'contact_number' => 'string',
            'device_id' => 'string',
            'preferences' => 'array',
            'profile_picture' => 'nullable',
            'role' => 'numeric',
            'verified' => 'boolean'
        ];
    }
}