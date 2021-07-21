<?php

namespace App\Acme\Requests;

class PermissionUpdateMultipleRequest extends ApiRequest
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
            'permission_ids' => 'array|required',
            'name' => 'string',
            'label' => 'string',
        ];
    }
}