<?php

namespace App\Acme\Services;

use App\Acme\Models\Currency;
use App\Acme\Resources\CurrencyResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class CurrencyService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getCurrencies($input)
    {
        $currencies = Currency::paginate();
        return CurrencyResource::collection($currencies);
    }

    public function createCurrency($input)
    {
        if (! $this->currentUserCan('createCurrency')) {
            return $this->respondWithNotAllowed();
        }

        $existingCurrency = Currency::where('currency', $input['currency'])->first();
        if (!empty($existingCurrency)) {
            return $this->respondWithError('Currency already exists.', 'CurrencyExistsException')->setStatusCode(400);
        }

        $currency = new Currency();
        $currency->fill($input);

        $currency->save();

        return new CurrencyResource($currency);
    }

    public function showCurrency($input)
    {
        if (!$this->currentUserCan('getCurrencies')) {
            return $this->respondWithNotAllowed();
        }

        $currency = Currency::findOrFail($input['currency_id']);
        return new CurrencyResource($currency);
    }

    public function updateCurrency($input)
    {
        if (!$this->currentUserCan('updateCurrency')) {
            return $this->respondWithNotAllowed();
        }


        $currency = Currency::findOrFail($input['currency_id']);
        $currency->fill($input);
        $currency->save();

        return new CurrencyResource($currency);
    }


    public function destroyCurrency($input)
    {
        if (!$this->currentUserCan('destroyCurrency')) {
            return $this->respondWithNotAllowed();
        }

        $currency = Currency::findOrFail($input['currency_id']);
        $currency->delete();
    }

    public function destroyMultipleCurrency($input)
    {
        if (!$this->currentUserCan('destroyCurrency')) {
            return $this->respondWithNotAllowed();
        }

        Currency::whereIn('id', $input['currency_ids'])->delete();
    }

}