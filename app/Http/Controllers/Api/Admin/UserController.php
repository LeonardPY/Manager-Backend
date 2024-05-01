<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\UserFilter;
use App\Http\Requests\User\Admin\FilterUserRequest;
use App\Http\Requests\User\Admin\StoreUserRequest;
use App\Http\Requests\User\Admin\UpdateUserRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class UserController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function index(FilterUserRequest $request): SuccessResource
    {
        $filter = app()->make(UserFilter::class, ['queryParams' => array_filter($request->validated())]);
        $users = $this->userRepository->getUsers($filter);
        return SuccessResource::make([
            'data' => UserResource::collection($users),
            'message' => 'users'
        ]);
    }

    public function store(StoreUserRequest $request): SuccessResource
    {
        $data = $request->validated();

        $user = $this->userRepository->create($data);

        return SuccessResource::make([
            'data' => $user
        ]);
    }
    public function show(User $user): SuccessResource
    {
        return SuccessResource::make([
            'data' => UserResource::make($user),
            'message' => 'user'
        ]);
    }

    public function update(User $user, UpdateUserRequest $request): SuccessResource
    {
        $data = $request->validated();

        $user->update($data);

        return SuccessResource::make([
            'message' => 'user successfully updated',
            'data' => $user
        ]);
    }

    public function destroy(User $user): SuccessResource
    {
        $user->update(['status' => UserStatusEnum::DELETED->value]);

        return SuccessResource::make([
            'message' => 'user successfully deleted',
        ]);
    }
}
