<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Return a successful response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success($data = null, $message = 'Operation successful', $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error response
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @param mixed $data
     * @return JsonResponse
     */
    public static function error($message = 'Operation failed', $statusCode = 400, $errors = null, $data = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a validation error response
     *
     * @param array $errors
     * @param string $message
     * @return JsonResponse
     */
    public static function validationError($errors, $message = 'Validation failed')
    {
        return self::error($message, 422, $errors);
    }

    /**
     * Return a not found response
     *
     * @param string $resource
     * @return JsonResponse
     */
    public static function notFound($resource = 'Resource')
    {
        return self::error("{$resource} not found", 404);
    }

    /**
     * Return an unauthorized response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function unauthorized($message = 'Unauthorized')
    {
        return self::error($message, 401);
    }

    /**
     * Return a forbidden response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function forbidden($message = 'Forbidden')
    {
        return self::error($message, 403);
    }

    /**
     * Return a server error response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function serverError($message = 'Internal server error')
    {
        return self::error($message, 500);
    }

    /**
     * Return a service unavailable response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function serviceUnavailable($message = 'Service temporarily unavailable')
    {
        return self::error($message, 503);
    }

    /**
     * Return a conflict response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function conflict($message = 'Resource conflict')
    {
        return self::error($message, 409);
    }

    /**
     * Return a too many requests response
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function tooManyRequests($message = 'Too many requests. Please try again later.')
    {
        return self::error($message, 429);
    }
}
