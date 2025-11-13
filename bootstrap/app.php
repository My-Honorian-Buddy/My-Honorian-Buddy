<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Render specific exceptions
        $exceptions->render(function (Throwable $e) {
            // Handle validation exceptions
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }

            // Handle model not found exceptions
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                \Illuminate\Support\Facades\Log::warning('Model not found', [
                    'exception' => class_basename($e),
                    'message' => $e->getMessage(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);
            }

            // Handle authorization exceptions
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                \Illuminate\Support\Facades\Log::warning('Authorization failed', [
                    'user' => \Illuminate\Support\Facades\Auth::id(),
                    'message' => $e->getMessage(),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action',
                ], 403);
            }

            // Handle authentication exceptions
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                \Illuminate\Support\Facades\Log::info('Authentication required');
                
                return redirect()->route('login');
            }
        });

        // Log all exceptions
        $exceptions->report(function (Throwable $e) {
            if (!app()->environment('testing')) {
                \Illuminate\Support\Facades\Log::error('Unhandled Exception', [
                    'type' => class_basename($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        });
    })->create();
