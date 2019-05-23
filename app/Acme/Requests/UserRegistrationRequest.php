<?php

namespace App\Acme\Requests;

class UserRegistrationRequest extends ApiRequest
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
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'email' => 'required|string',
            'password' => 'required|string|min:8|max:20',
            'gender' => 'required|string',
            'contact_number' => 'required|string',
            'device_id' => 'string',
            'preferences' => 'array',
        ];
    }
}
