<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if (!$request->is('api/*')) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'status' => "error",
                'message' => "Validation Failed!",
                'errors' => $exception->validator->errors()
            ], 400);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'status' => "error",
                'message' => "Not Found!",
                'errors' => null
            ], 404);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => "error",
            'message' => 'User Unauthenticated!',
            'errors' => null
        ], 401);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
