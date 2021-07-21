<?php

namespace App\Acme\Requests;

class MeGetWithdrawRequestsRequest extends ApiRequest
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

    public function getWithdrawRequestsFilter()
    {
        return [
            'limit' => $this->get('limit', null),
            'ascending' => $this->get('ascending', null),
            'page' => $this->get('page', null),
            'byColumn' => $this->get('byColumn', null),
            'orderBy' => $this->get('orderBy', null),
        ];
    }
}