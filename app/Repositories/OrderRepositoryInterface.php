<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Filters\OrderFilter;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserOrders(int $userId, OrderFilter $filter): object;
    public function getOrderById(int $id): object;
}
