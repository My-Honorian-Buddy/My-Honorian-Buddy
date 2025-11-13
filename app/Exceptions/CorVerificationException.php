<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CorVerificationException extends Exception
{
    protected $userMessage;

    public function __construct($message = "COR verification failed", $userMessage = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->userMessage = $userMessage ?? $message;
        
        // Log the error for debugging
        Log::error('COR Verification Error', [
            'message' => $message,
            'user_message' => $this->userMessage,
            'trace' => $this->getTraceAsString(),
        ]);
    }

    public function getUserMessage()
    {
        return $this->userMessage;
    }

    public function render()
    {
        return back()->with('status', '❌ ' . $this->userMessage);
    }
}
