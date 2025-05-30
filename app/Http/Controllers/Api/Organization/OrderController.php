<?php

namespace App\Http\Controllers\Api\Organization;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\OrderFilterRequest;
use App\Http\Requests\Department\OrderUpdateRequest;
use App\Http\Resources\Order\DepartmentOrderResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\OrderRepositoryInterface;
use App\Services\Organization\OrganizationOrderService;
use Illuminate\Contracts\Container\BindingResolutionException;

class OrderController extends Controller
{

    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly OrganizationOrderService $organizationOrderService
    ) {
    }

    /** @throws BindingResolutionException|ApiErrorException */
    public function index(OrderFilterRequest $request): PaginationResource
    {
        $filterData = $request->validated();
        $filter = $this->organizationOrderService->ordersWithFilter($filterData);
        $orders = $this->orderRepository->getDepartmentOrders(authUser()->id, $filter);
        return PaginationResource::make([
            'data' => DepartmentOrderResource::collection($orders),
            'pagination' => $orders
        ]);
    }

    /** @throws ApiErrorException */
    public function show(int $id): SuccessResource
    {
        $order = $this->orderRepository->getOrderById($id);
        $this->organizationOrderService->hasAccessToOrder(authUser(), $order);

        return SuccessResource::make([
            'data' => $order
        ]);
    }

    /** @throws ApiErrorException */
    public function update(OrderUpdateRequest $request, int $id): SuccessResource
    {
        $data = $request->validated();
        $order = $this->orderRepository->findOrFail($id);
        $this->organizationOrderService->hasAccessToOrder(authUser(), $order);
        $this->orderRepository->update($id, $data);
        return SuccessResource::make([
            'message' => trans('message.successfully_updated')
        ]);
    }
}
