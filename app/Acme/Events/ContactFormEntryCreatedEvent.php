<?php

namespace App\Acme\Events;

use App\Acme\Models\ContactFormEntry;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactFormEntryCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contactFormEntry;

    /**
     * Create a new event instance.
     * @param ContactFormEntry $contactFormEntry
     */
    public function __construct(ContactFormEntry $contactFormEntry)
    {
        $this->contactFormEntry = $contactFormEntry;
    }

}
