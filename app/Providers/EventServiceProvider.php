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
