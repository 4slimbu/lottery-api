<?php

namespace App\Acme\Requests\Location;

use App\Acme\Requests\ApiRequest;

class FindLocationRequest extends ApiRequest
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
            'label' => 'required|string|min:3'
        ];
    }
}