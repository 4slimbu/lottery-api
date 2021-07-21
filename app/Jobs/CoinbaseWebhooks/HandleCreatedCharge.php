<?php

namespace App\Jobs\CoinbaseWebhooks;

use App\Acme\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class HandleCreatedCharge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Shakurov\Coinbase\Models\CoinbaseWebhookCall */
    public $webhookCall;

    public function __construct(CoinbaseWebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        // you can access the payload of the webhook call with `$this->webhookCall->payload`
        if (! isset($this->webhookCall->payload["event"]["data"]["metadata"]["deposit_id"])) {
            return;
        }

        $depositId = $this->webhookCall->payload["event"]["data"]["metadata"]["deposit_id"];

        $deposit = Deposit::findOrFail($depositId);

        $deposit->status = "created";
        $deposit->save();
    }
}
