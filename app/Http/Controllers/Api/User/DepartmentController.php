<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\User\UserDepartmentFilter;
use App\Http\Requests\Product\ProductFilterRequest;
use App\Http\Requests\User\Department\FilterDepartmentRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Department\DepartmentService;
use Illuminate\Contracts\Container\BindingResolutionException;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly DepartmentService $departmentService
    ) {
    }

    /** @throws BindingResolutionException */
    public function index(FilterDepartmentRequest $request): SuccessResource
    {
        $filterData = $request->validated();
        $filter = app()->make(UserDepartmentFilter::class, ['queryParams' => $filterData]);
        $users = $this->userRepository->getUsersByRoleId(UserRoleEnum::DEPARTMENT_FACTORY->value, $filter);
        return SuccessResource::make([
            'data' => UserResource::collection($users),
        ]);
    }

    /** @throws BindingResolutionException */
    public function show(User $user, ProductFilterRequest $request): SuccessResource
    {
        $departmentProducts = $this->departmentService->departmentWithProducts(
            $user,
            $request->validated()
        );

        return SuccessResource::make([
            'data' => [
                'department' => UserResource::make($user),
                'departmentProducts' => ProductResource::collection($departmentProducts)
            ],
        ]);
    }
}
