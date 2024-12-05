<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\ErrorResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class DepartmentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws ApiErrorException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (authUser()->user_role_id != UserRoleEnum::USER) {
            return $next($request);
        }
        return (new ErrorResource([
            'message' => 'Forbidden'
        ]))->response()->setStatusCode(403);
    }
}
