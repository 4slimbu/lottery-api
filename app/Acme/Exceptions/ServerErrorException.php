<?php

namespace App\Acme\Exceptions;

class ServerErrorException extends ApiException {
    protected $code = 500;
    protected $message = 'Server error.';
    protected $apiErrorCode = 'ServerErrorException';
}