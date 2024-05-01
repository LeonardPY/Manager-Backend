<?php

namespace App\Repositories;

use App\Http\Filters\ProductFilter;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function allProduct(ProductFilter $filter, int $userId);

    public function slugExists(string $slug): object|bool;
}
