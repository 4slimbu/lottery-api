<?php

namespace App\Jobs\CoinbaseWebhooks;

use App\Acme\Models\Currency;
use App\Acme\Models\Deposit;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Services\WalletService;
use App\Events\UserUpdateEvent;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class HandleConfirmedCharge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Shakurov\Coinbase\Models\CoinbaseWebhookCall */
    public $webhookCall;

    public function __construct(CoinbaseWebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        // you can access the payload of the webhook call with `$payload`
        $payload = $this->webhookCall->payload;

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

            // We have setup conversion for USD only. If not, don't proceed further
            if ($localCurrency === 'USD') {
                $client = new Client();
                $res = $client->get('https://blockchain.info/tobtc?currency=USD&value=' . $localAmount);
                $amount = $res->getBody()->getContents();
            } else {
                throw new \Exception('Failed Currency conversion', 500);
            }
        }

        // Get related wallet
        $wallet = Wallet::findOrFail($deposit->wallet_id);

        // Create top-up wallet transaction
        $walletService = new WalletService();
        $appCoinModel = Currency::where('currency', 'BTC')->first();
        $walletService->handleTransaction($wallet, "top-up", $amount * $appCoinModel->value_in_app_coin);

        // Update deposit with the amount and currency
        $deposit->save();

        // Fire user updated event
        $user = User::findOrFail($deposit->user_id);
        event(new UserUpdateEvent($user));
    }
}
