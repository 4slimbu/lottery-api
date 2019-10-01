<?php

namespace App\Acme\Emails;

use App\Acme\Models\Currency;
use App\Acme\Models\WalletTransaction;
use App\Acme\Models\WithdrawRequest;
use App\Events\WalletTransactionEvent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Acme\Models\User;


class WithdrawRequestEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $withdrawRequest;
    protected $user;
    protected $currency;

    /**
     * Create a new message instance.
     *
     * @param WithdrawRequest $withdrawRequest
     * @param User $user
     */
    public function __construct(WithdrawRequest $withdrawRequest, User $user)
    {
        $this->withdrawRequest = $withdrawRequest;
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
            'amount' => $this->currency->bitsToBtc($this->withdrawRequest->amount),
            'status' => $this->withdrawRequest->status,
            'created_at' => (new Carbon($this->withdrawRequest->created_at))->toDateTimeString()
        ];

        return $this->markdown('emails.withdraw-request')->with($data);
    }
}