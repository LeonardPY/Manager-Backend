<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Hashing\HashManager;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly HashManager $hashManager
    ) {
    }

    /**
     * @param LoginRequest $request
     * @return SuccessResource|ErrorResource
     * @throws ValidationException
     */
    public function login(LoginRequest $request): SuccessResource|ErrorResource
    {
        $request = $request->validated();;
        $user = $this->userRepository->findByEmail($request['email']);
        if (!$user || !$this->hashManager->check($request['password'], $user->password)) {
            return ErrorResource::make([
                'message' => trans('auth.failed')
            ])->setStatusCode(422);
        }
        $token = $user->createToken('user')->plainTextToken;

        return SuccessResource::make([
            'data' => [
                'user' => UserResource::make($user),
                'auth' => [
                    'token' => $token
                ]
            ]
        ])->setStatusCode(200);
    }

    /** @throws ApiErrorException */
    public function user(): SuccessResource
    {
        $user = authUser();
        return SuccessResource::make([
            'data' => [
                'user' => UserResource::make(
                    $this->userRepository->findById($user->getAttribute('id'))
                ),
            ]
        ]);
    }

    /** @throws ApiErrorException */
    public function logout(LogoutRequest $request): SuccessResource|ErrorResource
    {
        $user = authUser();
        $user->tokens()->delete();
        return SuccessResource::make([
            'message' => trans('messages.logged_out')
        ]);
    }

    /** @throws ApiErrorException */
    public function refresh(): SuccessResource
    {
        $user = authUser();;
        $newToken = $user->createToken('authToken')->plainTextToken;
        return SuccessResource::make([
            'data' => [
                'user' => UserResource::make($this->userRepository->findById($user->getAttribute('id'))),
                'auth' => [
                    'token' => $newToken
                ]
            ]
        ]);
    }
}
