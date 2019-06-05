<?php

namespace App\Acme\Requests;

class RoleGetRequest extends ApiRequest
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
        return [];
    }

    public function getFilter()
    {
        return [
            'limit' => $this->get('limit', null),
            'ascending' => $this->get('ascending', null),
            'page' => $this->get('page', null),
            'byColumn' => $this->get('byColumn', null),
            'orderBy' => $this->get('orderBy', null),
            'name' => $this->get('name', null),
            'with' => $this->get('with', null),
        ];
    }
}