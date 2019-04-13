<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\BaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            $baseController = new BaseController();
            return $baseController->sendError('Information not found for: ' . URL::full());
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            $baseController = new BaseController();
            return $baseController->sendError($exception->getMessage(), [], 405);
        }
        if ($exception instanceof InvalidArgumentException) {
            $baseController = new BaseController();
            return $baseController->sendError($exception->getMessage(), [], 400);
        }
        if ($exception instanceof AuthenticationException) {
            $baseController = new BaseController();
            return $baseController->sendError('Unauthenticated. You need to be logged to make that action', [], 401);
        }

        return parent::render($request, $exception);
    }
}
