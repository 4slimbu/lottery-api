<?php

namespace App\Acme\Emails;

use App\Acme\Models\Currency;
use App\Acme\Models\WalletTransaction;
use App\Events\WalletTransactionEvent;
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
     * @param Currency $currency
     */
    public function __construct(WalletTransaction $walletTransaction, User $user, Currency $currency)
    {
        $this->walletTransaction = $walletTransaction;
        $this->user = $user;
        $this->currency = $currency;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.wallet-transaction')->with([
            'fullname' => $this->user->first_name . ' ' . $this->user->last_name,
            'transaction_code' => $this->walletTransaction->transaction_code,
            'transaction_type' => $this->walletTransaction->type,
            'amount_in_btc' => $this->currency->bitsToBtc($this->walletTransaction->amount),
            'amount_in_coin' => $this->currency->bitsToCoin($this->walletTransaction->amount),
            'created_at' => $this->walletTransaction->created_at
        ]);
    }
}