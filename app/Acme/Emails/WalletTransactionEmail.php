<?php

namespace App\Acme\Emails;

use App\Acme\Models\Currency;
use App\Acme\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Acme\Models\User;


class WalletTransactionEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $walletTransaction;
    protected $user;
    protected $currency;
    /**
     * Create a new message instance.
     *
     * @param WalletTransaction $walletTransaction
     * @param User $user
     */
    public function __construct(WalletTransaction $walletTransaction, User $user)
    {
        $this->walletTransaction = $walletTransaction;
        $this->user = $user;
        $this->currency = new Currency();
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'fullname' => $this->user->first_name . ' ' . $this->user->last_name,
            'transaction_code' => $this->walletTransaction->transaction_code,
            'transaction_type' => $this->walletTransaction->type,
            'amount_in_btc' => $this->currency->bitsToBtc($this->walletTransaction->amount),
            'service_charge_in_btc' => $this->currency->bitsToBtc($this->walletTransaction->service_charge),
            'amount_in_coin' => $this->currency->bitsToCoin($this->walletTransaction->amount),
            'created_at' => (new Carbon($this->walletTransaction->created_at))->toDateTimeString(),
            'won' => $this->currency->bitsToBtc($this->walletTransaction->wallet->won),
            'pending_withdraw' => $this->currency->bitsToBtc($this->walletTransaction->wallet->pending_withdraw),
            'deposit' => $this->currency->bitsToCoin($this->walletTransaction->wallet->deposit)
        ];

        return $this->markdown('emails.wallet-transaction')->with($data);
    }
}