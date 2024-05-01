<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use App\Http\Resources\ErrorResource;
use App\Repositories\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class AdminMiddleware
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->userRepository->findOrFail(auth()->id());
        if ($user->getAttribute('user_role_id') === UserRoleEnum::ADMIN) {
            return $next($request);
        }
        return (new ErrorResource([
            'message' => 'Forbidden'
        ]))->response()->setStatusCode(403);
    }
}
