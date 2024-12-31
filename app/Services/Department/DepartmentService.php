<?php

declare(strict_types=1);

namespace App\Services\Department;


use App\Http\Filters\ProductFilter;
use App\Models\User;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class DepartmentService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    /** @throws BindingResolutionException */
    public function departmentWithProducts(User $user, array $filterData): LengthAwarePaginator
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => $filterData]);
        return $this->productRepository->allProduct($filter, $user->id);
    }
}
