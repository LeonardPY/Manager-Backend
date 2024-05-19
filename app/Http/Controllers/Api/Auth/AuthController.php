<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return SuccessResource|ErrorResource
     */
    public function login(LoginRequest $request): SuccessResource|ErrorResource
    {
        $request->validated();
        $token = Auth::attempt($request->only(['email', 'password']));

        if (!$token) {
            return ErrorResource::make([
                'message' => trans('auth.failed')
            ]);
        }
        /**
         * @var User $user
         */
        $user = auth()->user();

        return SuccessResource::make([
            'data' => [
                'user' => UserResource::make($this->userRepository->findById($user->getAttribute('id'))),
                'auth' => [
                    'token' => $token
                ]
            ]
        ]);
    }

    public function user(): SuccessResource
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return SuccessResource::make([
            'data' => [
                'user' => UserResource::make($this->userRepository->findById($user->getAttribute('id'))),
            ]
        ]);
    }

    public function logout(LogoutRequest $request): SuccessResource|ErrorResource
    {
        $token = JWTAuth::getToken();
        if ($token) {
            try {
                JWTAuth::invalidate($token);
            } catch (Exception) {
                return ErrorResource::make([
                    'message' => trans('messages.invalid_token')
                ]);
            }
        }
        return SuccessResource::make([
            'message' => trans('messages.logged_out')
        ]);
    }

    public function refresh(): SuccessResource
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return SuccessResource::make([
            'data' => [
                'user' => UserResource::make($this->userRepository->findById($user->getAttribute('id'))),
                'auth' => [
                    'token' => auth()->refresh()
                ]
            ]
        ]);
    }
}
