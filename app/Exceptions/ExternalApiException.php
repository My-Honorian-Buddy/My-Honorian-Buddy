<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ExternalApiException extends Exception
{
    protected $userMessage;
    protected $apiName;
    protected $statusCode;

    public function __construct($apiName = "External API", $message = "API request failed", $statusCode = 500, $userMessage = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->apiName = $apiName;
        $this->statusCode = $statusCode;
        $this->userMessage = $userMessage ?? "Failed to communicate with {$apiName}. Please try again later.";
        
        Log::error('External API Error', [
            'api' => $apiName,
            'status_code' => $statusCode,
            'message' => $message,
            'user_message' => $this->userMessage,
        ]);
    }

    public function getUserMessage()
    {
        return $this->userMessage;
    }

    public function getApiName()
    {
        return $this->apiName;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->userMessage,
        ], 503);
    }
}
