<?php

namespace App\Acme\Requests;

class SettingCreateRequest extends ApiRequest
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
            'key' => 'required|string',
            'label' => 'required|string',
            'value' => 'required|string',
            'field' => 'required|string',
            'field_value' => 'required|string',
        ];
    }
}