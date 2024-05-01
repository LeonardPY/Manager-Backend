<?php

namespace App\Repositories;

use App\Http\Filters\CategoryFilter;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function allCategories(CategoryFilter $filter, int $userId);

    public function slugExists(string $slug): object|bool;
}
