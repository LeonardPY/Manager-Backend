<?php

namespace App\Services\Organization;

use App\Enums\OrderStatus;
use App\Http\Filters\Department\OrderDepartmentFilter;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;

class OrganizationOrderService
{
    /** @throws BindingResolutionException */
    public function ordersWithFilter(array $filterData): OrderDepartmentFilter
    {
        $filterData = array_filter($filterData);
        if (!isset($filterData['status'])) {
            $filterData['status'] = OrderStatus::PENDING->value;
        }

        return $this->makeDepartmentFilter($filterData);
    }

    /** @throws BindingResolutionException */
    public function makeDepartmentFilter(array $filterData): OrderDepartmentFilter
    {
        return app()->make(OrderDepartmentFilter::class, [
            'queryParams' => $filterData
        ]);
    }

    public function hasAccessToOrder(User $user, Order $order): bool
    {
        return $this->userAccess($user, $order) && $this->accessStatuses($order);
    }

    public function userAccess(User $user, Order $order): bool
    {
        return $user->id === $order->department_id;
    }

    public function accessStatuses(Order $order): bool
    {
        return in_array($order->status, [
            OrderStatus::PENDING->value,
            OrderStatus::CONFIRM_DELIVERY->value,
        ]);
    }
}
