<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\CurrencyCreateRequest;
use App\Acme\Requests\CurrencyDestroyMultipleRequest;
use App\Acme\Requests\CurrencyGetRequest;
use App\Acme\Requests\CurrencyUpdateMultipleRequest;
use App\Acme\Requests\CurrencyUpdateRequest;
use App\Acme\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends ApiController
{
    private $currencyService;
    public function __construct(CurrencyService $currencyService)
    {
        $this->middleware('auth:api')->except('checkEmail');
        $this->currencyService = $currencyService;
    }

    public function index(CurrencyGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->currencyService->getCurrencies($input);
    }

    public function create(CurrencyCreateRequest $request)
    {
        $input = $request->getInput();
        return $this->currencyService->createCurrency($input);
    }

    public function show($currencyId)
    {
        $input['currency_id'] = $currencyId;
        return $this->currencyService->showCurrency($input);
    }

    public function update(CurrencyUpdateRequest $request, $currencyId)
    {
        $input = $request->getInput();
        $input['currency_id'] = $currencyId;
        return $this->currencyService->updateCurrency($input);
    }

    public function updateMultiple(CurrencyUpdateMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->currencyService->updateMultipleCurrency($input);
    }

    public function destroy($currencyId)
    {
        $input['currency_id'] = $currencyId;
        return $this->currencyService->destroyCurrency($input);
    }

    public function destroyMultiple(CurrencyDestroyMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->currencyService->destroyMultipleCurrency($input);
    }

}