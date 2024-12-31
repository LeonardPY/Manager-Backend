<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\User\UserFilter;
use App\Http\Requests\User\Admin\FilterUserRequest;
use App\Http\Requests\User\Admin\StoreUserRequest;
use App\Http\Requests\User\Admin\UpdateUserRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\User\UserService;
use Illuminate\Contracts\Container\BindingResolutionException;

class UserController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserService             $userService
    ) {
    }

    /** @throws BindingResolutionException */
    public function index(FilterUserRequest $request): PaginationResource
    {
        $filter = app()->make(UserFilter::class, [
            'queryParams' => array_filter($request->validated())
        ]);
        $users = $this->userRepository->getUsers($filter);

        return PaginationResource::make([
            'message' => trans('message.success'),
            'data' => UserResource::collection($users),
            'pagination' => $users
        ]);
    }

    public function store(StoreUserRequest $request): SuccessResource
    {
        $data = $this->userService->uploadUserLogo($request->validated());
        $user = $this->userRepository->create($data);

        return SuccessResource::make([
            'data' => UserResource::make($user)
        ]);
    }

    public function show(User $user): SuccessResource
    {
        return SuccessResource::make([
            'message' => trans('message.success'),
            'data' => UserResource::make($user),
        ]);
    }

    public function update(User $user, UpdateUserRequest $request): SuccessResource
    {
        $data = $request->validated();

        $this->userRepository->update($user->id, $data);

        return SuccessResource::make([
            'message' => trans('message.successfully_updated'),
            'data' => UserResource::make($user),
        ]);
    }

    public function destroy(User $user): SuccessResource
    {
        $this->userRepository->update($user->id, [
            'status' => UserStatusEnum::DELETED->value
        ]);

        return SuccessResource::make([
            'message' => trans('message.successfully_deleted'),
        ]);
    }
}
