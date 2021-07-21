<?php

namespace App\Acme\Listeners\Registration;

use App\Acme\Emails\ResetPasswordEmail;
use App\Acme\Events\Registration\UserForgotPasswordEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendResetPasswordEmailListener
{
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
     * @param UserForgotPasswordEvent $event
     * @return void
     */
    public function handle(UserForgotPasswordEvent $event)
    {
        /**
         * Todo: This is not required as Auth is handled by laravel. But still confirm it.
         */
        Mail::to($event->user->email)->send(new ResetPasswordEmail($event->user, $event->token));
    }
}
