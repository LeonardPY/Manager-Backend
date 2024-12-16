<?php

namespace App\Repositories\Eloquent;

use App\Http\Filters\CategoryFilter;
use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function allCategories(CategoryFilter $filter, int $userId): LengthAwarePaginator
    {
        return $this->model->with('subCategory.subCategory')
            ->where([
                ['user_id', $userId],
                ['parent_id', null],
            ])
            ->filter($filter)->paginate($filter->PER_PAGE);
    }
    public function slugExists(string $slug): bool
    {
        return $this->model->where('slug', $slug)->exists();
    }
}
