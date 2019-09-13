<?php

namespace App\Listeners;

use App\Acme\Models\Setting;
use App\Events\WalletTransactionEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class WalletTransactionEventListener implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WalletTransactionEvent  $event
     * @return void
     */
    public function handle(WalletTransactionEvent $event)
    {
        switch ($event->walletTransaction->type) {
            case 'win':
//                Mail::to($event->walletTransaction->user->email)->send(new WalletTransactionEmail($user));
                break;
            default:
                break;
        }
    }
}
