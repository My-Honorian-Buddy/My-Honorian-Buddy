<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ErrorHandling
{
    /**
     * Execute a database operation with comprehensive error handling
     *
     * @param callable $operation
     * @param string $operationName
     * @param string|null $userMessage
     * @return mixed
     * @throws \App\Exceptions\DatabaseOperationException
     */
    public function executeDbOperation(callable $operation, $operationName = "Database operation", $userMessage = null)
    {
        try {
            return $operation();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \App\Exceptions\DatabaseOperationException(
                $operationName,
                $e->getMessage(),
                $userMessage ?? "An error occurred while processing your request. Please try again."
            );
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseOperationException(
                $operationName,
                $e->getMessage(),
                $userMessage ?? "An unexpected error occurred. Please try again."
            );
        }
    }

    /**
     * Execute a file operation with comprehensive error handling
     *
     * @param callable $operation
     * @param string $operationName
     * @param string|null $userMessage
     * @return mixed
     * @throws \App\Exceptions\FileOperationException
     */
    public function executeFileOperation(callable $operation, $operationName = "File operation", $userMessage = null)
    {
        try {
            return $operation();
        } catch (\Exception $e) {
            throw new \App\Exceptions\FileOperationException(
                $operationName,
                $e->getMessage(),
                $userMessage ?? "Failed to process file. Please try again."
            );
        }
    }

    /**
     * Execute an external API call with error handling
     *
     * @param callable $operation
     * @param string $apiName
     * @param int $maxRetries
     * @param string|null $userMessage
     * @return mixed
     * @throws \App\Exceptions\ExternalApiException
     */
    public function executeApiCall(callable $operation, $apiName = "External API", $maxRetries = 3, $userMessage = null)
    {
        $lastException = null;

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                return $operation();
            } catch (\Exception $e) {
                $lastException = $e;
                
                Log::warning("API call attempt {$attempt}/{$maxRetries} failed for {$apiName}", [
                    'api' => $apiName,
                    'attempt' => $attempt,
                    'error' => $e->getMessage(),
                ]);

                // Don't retry on the last attempt
                if ($attempt === $maxRetries) {
                    break;
                }

                // Exponential backoff: wait 1s, 2s, 4s
                sleep(pow(2, $attempt - 1));
            }
        }

        throw new \App\Exceptions\ExternalApiException(
            $apiName,
            $lastException->getMessage(),
            500,
            $userMessage ?? "Failed to communicate with {$apiName}. Please try again later."
        );
    }

    /**
     * Handle validation with consistent error responses
     *
     * @param array $rules
     * @param array $data
     * @param array $messages
     * @param array $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateRequest(array $rules, array $data, array $messages = [], array $customAttributes = [])
    {
        return \Illuminate\Support\Facades\Validator::make(
            $data,
            $rules,
            $messages,
            $customAttributes
        );
    }

    /**
     * Log an operation start
     *
     * @param string $operation
     * @param array $context
     * @return void
     */
    public function logOperationStart($operation, array $context = [])
    {
        Log::info("Starting operation: {$operation}", $context);
    }

    /**
     * Log an operation success
     *
     * @param string $operation
     * @param array $context
     * @return void
     */
    public function logOperationSuccess($operation, array $context = [])
    {
        Log::info("Completed operation: {$operation}", $context);
    }

    /**
     * Log an operation failure
     *
     * @param string $operation
     * @param string $error
     * @param array $context
     * @return void
     */
    public function logOperationFailure($operation, $error, array $context = [])
    {
        Log::error("Failed operation: {$operation}", array_merge(['error' => $error], $context));
    }
}
