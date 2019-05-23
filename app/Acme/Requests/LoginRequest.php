<?php

namespace App\Acme\Requests;

class LoginRequest extends ApiRequest
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
            'email' => 'required_without:fb_token|email',
            'password' => 'required_without:fb_token|string',
            'fb_token' => 'required_without:email,password|string'
        ];
    }
}
