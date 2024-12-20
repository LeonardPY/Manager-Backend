<?php

namespace App\Http\Controllers\Api\Refund\Store;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Filters\Refund\RefundOrderFilter;
use App\Http\Requests\RefundOrder\RefundOrderFilterRequest;
use App\Http\Requests\RefundOrder\RefundOrderRequest;
use App\Http\Resources\Refund\OrderRefundResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\RefundOrderRepositoryInterface;
use App\Services\Refund\RefundOrderService;
use Illuminate\Contracts\Container\BindingResolutionException;

class StoreRefundOrderController extends Controller
{
    public function __construct(
        private readonly RefundOrderRepositoryInterface $refundOrderRepository,
        private readonly OrderProductRepositoryInterface $orderProductRepository,
        Private readonly RefundOrderService $refundOrderService
    ) {
    }

    /** @throws ApiErrorException|BindingResolutionException */
    public function index(RefundOrderFilterRequest $request): SuccessResource
    {
        $user = authUser();
        $filter = app()->make(RefundOrderFilter::class, [
            'queryParams' => array_filter($request->validated())
        ]);
        $refundOrders = $this->refundOrderRepository->filterRefundOrderByStoreId(
            $user->id,
            $filter
        );
        return new SuccessResource([
            'data' => OrderRefundResource::collection($refundOrders),
        ]);
    }

    /** @throws ApiErrorException */
    public function store(RefundOrderRequest $request): SuccessResource
    {
        $data = $request->validated();
        $user = authUser();
        /** @var int $orderProductId */
        $orderProductId = $data['order_product_id'];
        $orderProduct = $this->orderProductRepository->getOrderProductWithOrder($orderProductId);
        $refundOrder = $this->refundOrderService->processRefund($user, $orderProduct, $data);
        return new SuccessResource([
            'data' => OrderRefundResource::make($refundOrder),
        ]);
    }
}
