<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Filters\OrderFilter;
use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;

final class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getUserOrders(int $userId, OrderFilter $filter): object
    {
        return $this->model->with('orderProducts')->where('user_id', $userId)->filter($filter)->paginate(25);
    }

    public function getOrderById(int $id): Order
    {
        return $this->model->with(['user' => function ($query) {
            return $query->select(['id', 'name', 'email']);
        }, 'department' => function ($query) {
            return $query->select(['id', 'name', 'email', 'country_id'])->with('country');
        }, 'orderProducts' => function ($query) {
            return $query->with(['product' => function ($query) {
                return $query->select('id', 'name', 'price', 'product_code', 'slug', 'discount_percent')->with('mainPicture');
            }]);
        }])->findOrFail($id);
    }

    public function getOrderByIdAndUserId(int $id, int $userId): Order
    {
        return $this->model->where('id', $id)->with(['user' => function ($query) use ($userId) {
            return $query->where('id', $userId);
        }])->firstOrFail();
    }
}
