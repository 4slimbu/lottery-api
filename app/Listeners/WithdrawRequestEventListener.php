<?php

namespace App\Listeners;

use App\Acme\Emails\WalletTransactionEmail;
use App\Acme\Emails\WithdrawRequestEmail;
use App\Acme\Models\Setting;
use App\Events\WalletTransactionEvent;
use App\Events\WithdrawRequestEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class WithdrawRequestEventListener implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param WithdrawRequestEvent $event
     * @return void
     */
    public function handle(WithdrawRequestEvent $event)
    {
        Mail::to($event->user->email)->send(new WithdrawRequestEmail($event->withdraw_request, $event->user));
    }
}
