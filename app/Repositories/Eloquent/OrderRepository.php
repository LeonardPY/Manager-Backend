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

    public function getOrderById(int $id): object
    {
        return $this->model->with('orderProducts')->findOrFail($id);
    }
}
