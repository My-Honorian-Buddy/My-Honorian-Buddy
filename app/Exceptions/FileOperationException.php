<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class FileOperationException extends Exception
{
    protected $userMessage;
    protected $operation;

    public function __construct($operation = "File operation", $message = "Failed to complete file operation", $userMessage = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->operation = $operation;
        $this->userMessage = $userMessage ?? $message;
        
        Log::error('File Operation Error', [
            'operation' => $operation,
            'message' => $message,
            'user_message' => $this->userMessage,
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
        ], 400);
    }
}
