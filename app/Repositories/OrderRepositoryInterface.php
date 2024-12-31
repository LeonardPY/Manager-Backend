<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Filters\Department\OrderDepartmentFilter;
use App\Http\Filters\OrderFilter;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserOrders(int $userId, OrderFilter $filter): object;
    public function getOrderById(int $id): Order;
    public function getOrderByIdAndUserId(int $id, int $userId): Order;

    public function getDepartmentOrders(int $departmentId, OrderDepartmentFilter $filter): LengthAwarePaginator;
}
