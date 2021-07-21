<?php

namespace App\Acme\Emails;

use App\Acme\Models\ContactFormEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Acme\Models\User;


class ContactFormEntryEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $contactFormEntry;
    public $userType;

    /**
     * Create a new message instance.
     *
     * @param ContactFormEntry $contactFormEntry
     * @param string $userType
     */
    public function __construct(ContactFormEntry $contactFormEntry, $userType = 'user')
    {
        $this->contactFormEntry = $contactFormEntry;
        $this->userType = $userType;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact-form-entry')->with([
            'name' => $this->contactFormEntry->name,
            'email' => $this->contactFormEntry->email,
            'subject' => $this->contactFormEntry->subject,
            'message' => $this->contactFormEntry->message,
            'userType' => $this->userType
        ]);
    }
}