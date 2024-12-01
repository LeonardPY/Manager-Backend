<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /** @var array<int, string> */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e) {
            return (new ErrorResource([
                'message' => trans('message.not_found')
            ]))->response()->setStatusCode(404);
        });

        $this->renderable(function (AuthenticationException $e) {
            return (new ErrorResource([
                'message' => 'Unauthenticated'
            ]))->response()->setStatusCode(401);
        });

        $this->renderable(function (HttpException $e) {
            return (new ErrorResource([
                'message' => $e->getMessage()
            ]))->response()->setStatusCode($e->getStatusCode());
        });

        $this->renderable(function (ValidationException $e) {
            return (new ErrorResource([
                'message' => $e->getMessage()
            ]))->response()->setStatusCode(422);
        });

        $this->renderable(function (Exception $e) {
            return (new ErrorResource([
                'message' => $e->getMessage()
            ]))->response()->setStatusCode(422);
        });
    }
}
