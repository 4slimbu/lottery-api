<?php

namespace App\Acme\Requests;

class MeUpdateRequest extends ApiRequest
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
            "gender" => 'string',
            'contact_number' => 'string',
            'preferences' => 'array',
            'profile_pic' => 'file|nullable',
        ];
    }
}