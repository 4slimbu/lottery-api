<?php

namespace App\Acme\Controllers;

use App\Acme\Services\CoinbaseService;
use Illuminate\Http\Request;

class CoinbaseController extends ApiController
{
    private $coinbaseService;

    public function __construct(CoinbaseService $coinbaseService)
    {
        $this->coinbaseService = $coinbaseService;
    }

    public function createCharge(Request $request)
    {
        $coins = $request->get('coins');

        // only allow fixed amount of coins
        if (
            $coins &&
            ($coins === 1 || $coins === 5 || $coins === 10 || $coins === 25 || $coins === 50 || $coins === 100)
        ) {
            return $this->coinbaseService->createCharge($coins);
        }

        return null;
    }

}