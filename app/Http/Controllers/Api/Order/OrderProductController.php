<?php

namespace App\Http\Controllers\Api\Order;

use App\Enums\OrderStatus;
use App\Exceptions\AccessDeniedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderProduct\StoreOrderProductRequest;
use App\Http\Requests\OrderProduct\UpdateOrderProductRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\OrderService;

class OrderProductController extends Controller
{

    public function __construct(
        private readonly OrderRepositoryInterface        $orderRepository,
        private readonly OrderProductRepositoryInterface $orderProductRepository,
        private readonly ProductRepositoryInterface      $productRepository,
        private readonly OrderService                    $orderService
    )
    {
    }

    public function store(StoreOrderProductRequest $cartProductRequest): SuccessResource|ErrorResource
    {
        $validated = $cartProductRequest->validated();

        $product = $this->productRepository->findOrFail((int)$validated['product_id']);

        if (!$product->haveAccess($validated['department_id'])) {
            return ErrorResource::make([
                'message' => trans('message.department_conflict'),
            ])->setStatusCode(409);
        };

        if ($product->count < $validated['quantity']) {
            return ErrorResource::make([
                'message' => trans('message.product_is_out_of_stock'),
            ])->setStatusCode(423);
        }
        $order = $this->orderRepository->updateOrCreate(['user_id' => auth()->id(), 'department_id' => $validated['department_id'], 'status' => OrderStatus::IN_CART->value], []);

        $this->orderProductRepository->updateOrcreate(['order_id' => $order->id, 'product_id' => $validated['product_id']], $validated + ['price' => $product->price]);

        return SuccessResource::make([
            'message' => trans('message.successfully_created'),
            'data' => $order
        ]);
    }

    /**
     * @throws AccessDeniedException
     */
    public function update(UpdateOrderProductRequest $request, int $id): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $orderProduct = $this->orderProductRepository->getOrderProductWithOrder($id);
        $this->orderService->haveProcessAccess($orderProduct->order, auth()->id());

        $product = $this->productRepository->findOrFail($orderProduct->product_id);

        if ($product->count < $data['quantity']) {
            return new ErrorResource([
                'message' => trans('message.product_is_out_of_stock'),
            ]);
        }
        $this->orderProductRepository->update($orderProduct->id, $data);

        return new SuccessResource([
            'message' => trans('message.successfully_updated'),
        ]);
    }

    /**
     * @throws AccessDeniedException
     */
    public function destroy(int $id): SuccessResource
    {
        $orderProduct = $this->orderProductRepository->getOrderProductWithOrder($id);
        $this->orderService->haveProcessAccess($orderProduct->order, auth()->id());
        $this->orderProductRepository->delete($orderProduct->id);

        return new SuccessResource([
            'message' => trans('message.successfully_deleted'),
        ]);
    }
}
