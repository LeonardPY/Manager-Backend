<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Filters\OrderFilter;
use App\Models\Order;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserOrders(int $userId, OrderFilter $filter): object;
    public function getOrderById(int $id): Order;
    public function getOrderByIdAndUserId(int $id, int $userId): Order;
}
