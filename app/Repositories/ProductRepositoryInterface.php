<?php

namespace App\Repositories;

use App\Http\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function allProduct(ProductFilter $filter, int $userId): LengthAwarePaginator;

    public function slugExists(string $slug): bool;

    public function findProductById(int $id): Product;
}
