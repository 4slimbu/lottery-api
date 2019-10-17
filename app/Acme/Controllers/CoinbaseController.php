<?php

namespace App\Acme\Controllers;

use App\Acme\Models\Currency;
use App\Acme\Models\Deposit;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Services\CoinbaseService;
use App\Acme\Services\WalletService;
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

    public function testPayload(Request $request)
    {
        // you can access the payload of the webhook call with `$payload`
        $payload = $request->all();

        // Probably not created by us if deposit_id doesn't exist in the metadata
        if (! isset($payload["event"]["data"]["metadata"]["deposit_id"])) {
            return;
        }

        // Get the related Deposit model
        $depositId = $payload["event"]["data"]["metadata"]["deposit_id"];
        $deposit = Deposit::findOrFail($depositId);

        // Get amount and currency of the payment
        $payment = $payload["event"]["data"]["payments"][0];
        $amount = $payment["value"]["crypto"]["amount"];
        $currency = $payment["value"]["crypto"]["currency"];

        // Update Deposit status to confirmed
        $deposit->status = "confirmed";
        $deposit->amount = $amount;
        $deposit->currency = $currency;

        // If payment is made in other crypto currency, then its corresponding USD is used to convert it to BTC
        if ($currency !== 'BTC') {
            $localAmount =  $payment["value"]["local"]["amount"];
            $localCurrency =  $payment["value"]["local"]["currency"];
            $amount = $localAmount;
            // Not required as we are using BTC as local currency.
            // We have setup conversion for USD only. If not, don't proceed further
//            if ($localCurrency === 'USD') {
//                $client = new Client();
//                $res = $client->get('https://blockchain.info/tobtc?currency=USD&value=' . $localAmount);
//                $amount = $res->getBody()->getContents();
//            } else {
//                throw new \Exception('Failed Currency conversion', 500);
//            }
        }
        // Get related wallet
        $wallet = Wallet::findOrFail($deposit->wallet_id);

        // Create top-up wallet transaction
        $walletService = new WalletService();
        $currency = new Currency();
        $walletTransactionId = $walletService->handleTransaction($wallet, "top-up", $currency->btcToBits($amount));
        // Update deposit with the amount and currency
        if ($walletTransactionId > 0) {
            $deposit->wallet_transaction_id = $walletTransactionId;
        }
        $deposit->save();

        return dd(true);
    }

}