<?php

namespace App\Repositories;

use App\Http\Filters\CategoryFilter;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function allCategories(CategoryFilter $filter, int $userId): LengthAwarePaginator;

    public function slugExists(string $slug): bool;
}
