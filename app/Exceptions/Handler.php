<?php

namespace App\Exceptions;

use App\Acme\Exceptions\ApiException;
use App\Acme\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (is_subclass_of($exception, ApiException::class)) {
            return $this->respondWithError($exception->getMessage(), $exception->getApiErrorCode())->setStatusCode($exception->getCode());
        }

        if ($exception instanceof QueryException) {
            return $this->respondWithError($exception->getMessage(), 'QueryException')->setStatusCode(500);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->respondWithError($exception->getMessage(), 'Unauthorized')->setStatusCode(401);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = class_basename($exception->getModel());
            $apiErrorCode = $model . 'NotFoundException';
            $message = $model . ' not found';
            return $this->respondWithError($message, $apiErrorCode)->setStatusCode(404);
        }

        if ($exception instanceof TokenExpiredException) {
            return $this->respondWithError($exception->getMessage(), 'TokenExpiredException')->setStatusCode(401);
        }

        if ($exception instanceof TokenBlacklistedException) {
            return $this->respondWithError($exception->getMessage(), 'TokenBlacklistedException')->setStatusCode(401);
        }

        return parent::render($request, $exception);
    }
}
