<?php

namespace App\Acme\Traits;

trait ApiResponseTrait
{
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondInternalError($message = 'Internal Server Error!', $apiErrorCode = 'internalServerError')
    {
        return $this->setStatusCode(500)->respondWithError($message, $apiErrorCode);
    }

    /**
     * @param array $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithValidationError($message = [], $apiErrorCode = '')
    {
        $msg = json_decode($message);
        if (!empty($msg)) {
            $message = $msg;
        }
        return $this->setStatusCode(400)->respondWithError($message, $apiErrorCode);
    }

    /**
     * @param string $message
     * @param string $apiErrorCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithNotAllowed($message = 'Not allowed.', $apiErrorCode = 'NotAllowedException')
    {
        return $this->setStatusCode(403)->respondWithError($message, $apiErrorCode);
    }

    /**
     * @param string $message
     * @param string $apiErrorCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message = 'Oops! Something went wrong.', $apiErrorCode = 'unknownError', $headers = [])
    {
        return response()->json([
            'error' => $apiErrorCode,
            'message' => $message
        ], $this->getStatusCode(), $headers);
    }

    /**
     * @param string $message
     * @param string $apiSuccessCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithSuccess($message = 'Success!', $apiSuccessCode = 'success', $headers = [])
    {
        return response()->json([
            'success' => $apiSuccessCode,
            'message' => $message
        ], $this->getStatusCode(), $headers);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data = '', $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }
}