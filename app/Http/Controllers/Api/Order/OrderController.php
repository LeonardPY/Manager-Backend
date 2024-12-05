<?php

namespace App\Http\Controllers\Api\Order;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Filters\OrderFilter;
use App\Http\Requests\Order\FilterOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Models\Order;
use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Services\OrderService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService                           $orderService,
        private readonly OrderRepositoryInterface               $orderRepository,
        private readonly OrderProductRepositoryInterface        $orderProductRepository,
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function index(FilterOrderRequest $request): PaginationResource
    {
        $validated = $request->validated();

        $filter = app()->make(OrderFilter::class, ['queryParams' => array_filter($validated)]);

        $orders = $this->orderRepository->getUserOrders(auth()->id(), $filter);

        return PaginationResource::make([
            'data' => OrderResource::collection($orders),
            'pagination' => $orders
        ]);
    }

    public function store(StoreOrderRequest $request): SuccessResource
    {
        $data = $request->validated();
        $order = $this->orderProductRepository->updateOrCreate(['user_id' => auth()->id(), 'department_id' => $data['department_id']],[]);

        $price = $this->orderService->calculate($order);

        return SuccessResource::make([
            'data' => [
                'order' => OrderResource::make($order),
                'calculate' => $price
            ]
        ]);
    }

    /**
     * @throws AccessDeniedException
     */
    public function update(UpdateOrderRequest $request, Order $order): SuccessResource
    {
        $data = $request->validated();
        $this->orderService->haveProcessAccess($order, auth()->id());
        $order = $this->orderRepository->getOrderById($order->id);
        $data = $this->orderService->userAddresses($data);
        $order->update($data);

        $price = $this->orderService->calculate($order);

        return SuccessResource::make([
            'data' => [
                'order' => OrderResource::make($order),
                'calculate' => $price
            ]
        ]);

    }

    /** @throws ApiErrorException */
    public function show(Order $order): SuccessResource|ErrorResource
    {
        $order = $this->orderRepository->getOrderById($order->id);
        $user = authUser();
        if (!Gate::forUser($user)->allows('authorize', $order)) {
            return ErrorResource::make([
                'message' => trans('message.access_denied')
            ])->setStatusCode(403);
        }

        $price = $this->orderService->calculate($order);

        return SuccessResource::make([
            'data' => [
                'order' => OrderResource::make($order),
                'calculate' => $price
            ]
        ])->setStatusCode(200);
    }

    /** @throws AccessDeniedException|ApiErrorException */
    public function destroy(int $id): SuccessResource|ErrorResource
    {
        $user = authUser();
        $order = $this->orderRepository->findOrFail($id);
        $this->orderService->haveProcessAccess($order, $user->id);

        $this->orderProductRepository->clearOrder($order->id);

        return new SuccessResource([
            'message' => trans('message.successfully_deleted'),
        ]);
    }

}
