<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\WalletGetRequest;
use App\Acme\Requests\WalletGetWithdrawRequest;
use App\Acme\Services\WalletService;

class WalletController extends ApiController
{
    private $walletService;
    public function __construct(WalletService $walletService)
    {
        $this->middleware('auth:api')->except('getWinners', 'showLotterySlot', 'close', 'getActiveSlot');
        $this->walletService = $walletService;
    }

    public function index(WalletGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->walletService->getWallets($input);
    }

    public function getWithdrawRequests(WalletGetWithdrawRequest $request) {
        $input = $request->getFilter();
        return $this->walletService->getWithdrawRequests($input);
    }

}