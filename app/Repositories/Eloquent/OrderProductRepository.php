<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\OrderProduct;
use App\Repositories\OrderProductRepositoryInterface;

final class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    public function __construct(OrderProduct $model)
    {
        parent::__construct($model);
    }

    public function getOrderProductWithOrder(int $id)
    {
        return $this->model->with('order')->findOrFail($id);
    }

    public function clearOrder(int $orderId): int|null
    {
        return $this->model->where('order_id', $orderId)->delete();
    }
}
