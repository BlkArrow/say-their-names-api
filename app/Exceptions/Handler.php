<?php

namespace App\Exceptions;

use Facade\Ignition\SolutionProviders\RouteNotDefinedSolutionProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if (
            $exception instanceof ModelNotFoundException
            || $exception instanceof MethodNotAllowedHttpException
            || $exception instanceof NotFoundHttpException
        ) {
            return response()->json([
                'errors' => [
                    'message' => '404 Not Found',
                ],
            ], 404);
        }
        return parent::render($request, $exception);
    }
}
