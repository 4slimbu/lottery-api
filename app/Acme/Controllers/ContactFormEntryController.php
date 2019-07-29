<?php

namespace App\Acme\Controllers;

use App\Acme\Requests\ContactFormEntryCreateRequest;
use App\Acme\Services\ContactFormEntryService;

class ContactFormEntryController extends ApiController
{
    private $contactFormEntryService;
    public function __construct(ContactFormEntryService $contactFormEntryService)
    {
        $this->middleware('auth:api')->except('create');
        $this->contactFormEntryService = $contactFormEntryService;
    }

    public function create(ContactFormEntryCreateRequest $request)
    {
        $input = $request->getInput();
        return $this->contactFormEntryService->createContactFormEntry($input);
    }

}