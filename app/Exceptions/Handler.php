<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('layouts.errors.404', [], 404);
        } elseif ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            
            return response()->view(
                'layouts.errors.403',
                ['error' => 'Sorry, this page is restricted to authorized users only.'],
                403
            );
        } elseif ($exception instanceof HttpException) {
            Log::info($exception->getMessage());
            return response()->view('layouts.errors.503', ['error' => $exception->getTrace()], 500);
        } else if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->view(
                'layouts.errors.403',
                ['error' => 'Sorry, this page is restricted to authorized users only.'],
                422
            );
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (in_array('employee', $exception->guards())) {
            return $request->expectsJson()
                ? response()->json([
                      'message' => $exception->getMessage()
                ], 401)
                : redirect()->guest(route('admin.login'));
        }
    
        return $request->expectsJson()
            ? response()->json([
                  'message' => $exception->getMessage()
            ], 401)
            : redirect()->guest(route('login'));
    }
}
