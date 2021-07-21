<?php

namespace App\Acme\Services;

use App\Acme\Events\ContactFormEntryCreatedEvent;
use App\Acme\Models\ContactFormEntry;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class ContactFormEntryService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function createContactFormEntry($input)
    {

        $contactFormEntry = new ContactFormEntry();
        $contactFormEntry->fill($input);

        event(new ContactFormEntryCreatedEvent($contactFormEntry));
        $status = $contactFormEntry->save();

        if ($status) {
           return $this->respondWithSuccess('Your inquiry was successfully submitted', 'ContactFormEntrySuccess');
        }

        return $this->setStatusCode(500)->respondWithError('Something went wrong. Try again', 'ContactFormEntryFailed');
    }


}