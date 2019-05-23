<?php

namespace App\Acme\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Acme\Models\User;


class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param null $token
     */
    public function __construct(User $user, $token = null)
    {
        $this->user = $user;
        $this->token = $token;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verification')->with([
            'name' => $this->user->first_name . ' ' . $this->user->last_name,
            'token' => $this->token
        ]);
    }
}