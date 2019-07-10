<?php

namespace App\Acme\Requests;

class WalletGetWithdrawRequest extends ApiRequest
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
            'slot_ref' => $this->get('slot_ref', null),
            'has_winner' => $this->get('has_winner', null),
            'total_participants' => $this->get('total_participants', null),
            'total_amount' => $this->get('total_amount', null),
            'result' => $this->get('result', null),
            'status' => $this->get('status', null),
            'with' => $this->get('with', null),
        ];
    }
}