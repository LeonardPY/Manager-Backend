<?php

namespace App\Repositories\Eloquent;

use App\Enums\ProductStatusEnum;
use App\Http\Filters\ProductFilter;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

final class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function allProduct(ProductFilter $filter, int $userId)
    {
        return $this->model->where('user_id', $userId)->with(['description' => function ($query) {
            return $query->select('id', 'product_id','short_description');
        }, 'category'=> function($query) {
           return $query->select('id', 'name');
        }])->whereNot('status', ProductStatusEnum::DELETED->value)->filter($filter)->paginate($filter->PER_PAGE);
    }

    public function slugExists(string $slug): object|bool
    {
        return $this->model->where('slug', $slug)->exists();
    }

    public function findProductById(int $id)
    {
        return $this->model->with(['description','pictures', 'category'=> function($query) {
            return $query->select('id', 'name');
        }])->whereNot('status', ProductStatusEnum::DELETED->value)->findOrFail($id);
    }
}
