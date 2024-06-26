<?php

namespace App\Exceptions;

use App\Helper\ResponseHelper;
use Exception;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Get the type of the error and throw an exception with details.
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        switch(get_class($exception))
        {
            case QueryException::class:
             return ResponseHelper::error($exception->getMessage());
            case AuthenticationException::class:
                return ResponseHelper::error($exception->getMessage());
                case ModelNotFoundException::class:
                    return ResponseHelper::error($exception->getMessage());
                    case TokenMismatchException::class:
                        return ResponseHelper::error($exception->getMessage());
                        case ValidationException::class:
                            return ResponseHelper::error($exception->getMessage());
                            case AuthorizationException::class:
                                return ResponseHelper::error($exception->getMessage());
                                case HttpException::class:
                                    return ResponseHelper::error($exception->getMessage());
                                    case NotFoundHttpException::class:
                                        return ResponseHelper::error($exception->getMessage());
                                        case MethodNotAllowedHttpException::class:
             return ResponseHelper::error($exception->getMessage());

        }
    }

    public function render($request, Throwable $exception)
    {
        return ResponseHelper::error($exception->getMessage());
    }
}
