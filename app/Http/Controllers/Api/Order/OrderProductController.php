<?php

namespace App\Http\Controllers\Api\Order;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderProduct\UpdateOrderProductRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\Order\OrderProductService;
use App\Services\OrderService;

class OrderProductController extends Controller
{

    public function __construct(
        private readonly OrderProductRepositoryInterface $orderProductRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly OrderService $orderService,
        private readonly OrderProductService $orderProductService
    ) {
    }

    /** @throws AccessDeniedException|ApiErrorException */
    public function update(UpdateOrderProductRequest $request, int $id): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $orderProduct = $this->orderProductRepository->getOrderProductWithOrder($id);

        $this->orderService->haveProcessAccess($orderProduct->order, authUser()->id);

        $product = $this->productRepository->findOrFail($orderProduct->product_id);

        $this->orderProductService->checkStock($product, $data['quantity']);

        $this->orderProductRepository->update($orderProduct->id, $data);

        return new SuccessResource([
            'message' => trans('message.successfully_updated'),
        ]);
    }

    /** @throws AccessDeniedException|ApiErrorException */
    public function destroy(int $id): SuccessResource
    {
        $orderProduct = $this->orderProductRepository->getOrderProductWithOrder($id);
        $this->orderService->haveProcessAccess($orderProduct->order, authUser()->id);
        $this->orderProductRepository->delete($orderProduct->id);

        return new SuccessResource([
            'message' => trans('message.successfully_deleted'),
        ]);
    }
}
