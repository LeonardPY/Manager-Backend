<?php
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DepartmentMiddleware;
use App\Http\Resources\ErrorResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'department' => DepartmentMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            return (new ErrorResource([
                'message' => 'Not Found'
            ]))->response()->setStatusCode(404);
        });
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return (new ErrorResource([
                'message' => 'Unauthenticated'
            ]))->response()->setStatusCode(401);
        });
        $exceptions->renderable(function (HttpException $e, $request) {
            return (new ErrorResource([
                'message' => $e->getMessage()
            ]))->response()->setStatusCode($e->getStatusCode());
        });

    })->create();
