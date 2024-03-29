<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Acme\Events\Registration\UserRegisteredEvent' => [
            'App\Acme\Listeners\Registration\SendWelcomeEmailListener',
        ],
        'App\Acme\Events\Registration\UserForgotPasswordEvent' => [
            'App\Acme\Listeners\Registration\SendResetPasswordEmailListener',
        ],
        'App\Acme\Events\Registration\UserVerifyEvent' => [
            'App\Acme\Listeners\Registration\SendVerificationEmailListener',
        ],
        'App\Acme\Events\ContactFormEntryCreatedEvent' => [
            'App\Acme\Listeners\ContactFormEntryCreatedEventListener',
        ],
        'App\Events\UserUpdateEvent' => [],
        // Lottery Events
        'App\Events\LotterySlotClosedEvent' => [],
        'App\Events\LotterySlotCreatedEvent' => [],
        'App\Events\LotterySlotResultGeneratedEvent' => [],
        'App\Events\ParticipantAddedEvent' => [],
        // Wallet Events
        'App\Events\WalletTransactionEvent' => [
            'App\Listeners\WalletTransactionEventListener'
        ],
        // Withdraw
        'App\Events\WithdrawRequestEvent' => [
            'App\Listeners\WithdrawRequestEventListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
