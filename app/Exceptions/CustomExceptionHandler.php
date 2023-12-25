<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomExceptionHandler extends ExceptionHandler
{
    public function render($request, \Throwable $exception)
    {
        // Handle Method Not Allowed exception for specific routes
        if ($exception instanceof MethodNotAllowedHttpException) {
            // You can customize the response here
            return response()->view('errors.method_not_allowed', [], 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            // Custom 404 page or redirect
            return response()->view('errors.404', [], 404);
        }

        return $this->handle500Error($request, $exception);
    }

    protected function handle500Error($request, Exception $exception)
    {
        // Log the exception or perform other actions as needed
        return response()->view('errors.500', [], 500);
    }
}
