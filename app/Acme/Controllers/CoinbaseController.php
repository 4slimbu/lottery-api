<?php

namespace App\Acme\Controllers;

use App\Acme\Services\CoinbaseService;

class CoinbaseController extends ApiController
{
    private $coinbaseService;

    public function __construct(CoinbaseService $coinbaseService)
    {
        $this->coinbaseService = $coinbaseService;
    }

    public function createCharge()
    {
        return $this->coinbaseService->createCharge();
    }

}