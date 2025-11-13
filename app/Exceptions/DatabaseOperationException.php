<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class DatabaseOperationException extends Exception
{
    protected $userMessage;
    protected $operation;

    public function __construct($operation = "Database operation", $message = "Database operation failed", $userMessage = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->operation = $operation;
        $this->userMessage = $userMessage ?? "An error occurred while processing your request.";
        
        Log::error('Database Operation Error', [
            'operation' => $operation,
            'message' => $message,
            'trace' => $this->getTraceAsString(),
        ]);
    }

    public function getUserMessage()
    {
        return $this->userMessage;
    }

    public function getOperation()
    {
        return $this->operation;
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->userMessage,
        ], 500);
    }
}
