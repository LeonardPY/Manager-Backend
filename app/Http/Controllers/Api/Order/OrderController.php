<?php

namespace App\Http\Controllers\Api\Order;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
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
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderProductRepositoryInterface $orderProductRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly OrderService $orderService,
    ) {
    }

    /** @throws BindingResolutionException|ApiErrorException */
    public function index(FilterOrderRequest $request): PaginationResource
    {
        $filter = $this->orderService->makeFilter($request->validated());

        $orders = $this->orderRepository->getUserOrders(authUser()->id, $filter);

        return PaginationResource::make([
            'data' => OrderResource::collection($orders),
            'pagination' => $orders
        ]);
    }

    /** @throws ApiErrorException|Throwable */
    public function store(StoreOrderRequest $request): SuccessResource
    {
        $data = $request->validated();

        $order = $this->orderService->makeOrderProduct(authUser(), $data);

        $price = $this->orderService->calculate($order);

        return SuccessResource::make([
            'data' => [
                'order' => OrderResource::make($order),
                'calculate' => $price
            ]
        ]);
    }

    /** @throws AccessDeniedException|ApiErrorException */
    public function update(UpdateOrderRequest $request, Order $order): SuccessResource
    {
        $data = $request->validated();
        $this->orderService->haveProcessAccess($order, authUser()->id);
        /** @var Order $order */
        $order = $this->orderRepository->getOrderById($order->id);
        $data = $this->orderService->userAddresses($data);
        $this->orderRepository->update($order->id, $data);

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
        /** @var Order $order */
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
