<?php

namespace App\Acme\Listeners;

use App\Acme\Emails\ContactFormEntryEmail;
use App\Acme\Events\ContactFormEntryCreatedEvent;
use App\Acme\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class ContactFormEntryCreatedEventListener implements ShouldQueue
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
     * @param ContactFormEntryCreatedEvent $event
     */
    public function handle(ContactFormEntryCreatedEvent $event)
    {
        $appEmail = Setting::where('key', 'app_email')->first();

        // Send mail to admin
        Mail::to($appEmail->value)->send(new ContactFormEntryEmail($event->contactFormEntry, 'admin'));

        // Send mail to client
        Mail::to($event->contactFormEntry->email)->send(new ContactFormEntryEmail($event->contactFormEntry));
    }
}
