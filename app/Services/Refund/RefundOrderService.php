<?php

namespace App\Services\Refund;

use App\Exceptions\ApiErrorException;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\RefundOrder;
use App\Models\RefundOrderProduct;
use App\Models\User;
use App\Repositories\Eloquent\RefundOrderRepository;
use App\Repositories\RefundOrderProductRepositoryInterface;

readonly class RefundOrderService
{
    public function __construct(
        private RefundOrderRepository $refundOrderRepository,
        private RefundOrderProductRepositoryInterface $refundOrderProductRepository
    ) {
    }

    /** @throws ApiErrorException */
    public function processRefund(
        User $user,
        OrderProduct $orderProduct,
        array $refundOrderProductData
    ): RefundOrder {
        $order = $orderProduct->order;
        $this->hasAccessRefund($user, $order);
        $this->checkCount($orderProduct, $refundOrderProductData['quantity']);
        $refundOrder = $this->refundOrder($user, $order);
        $this->refundOrderProduct($refundOrder, $orderProduct, $refundOrderProductData);
        return $refundOrder;
    }

    /** @throws ApiErrorException */
    public function hasAccessRefund(User $user, Order $order): bool
    {
        if ($order->haveProcessAccessRefund($user->id)) {
            throw new ApiErrorException('Access Denied!', 403);
        }
        return true;
    }

    /** @throws ApiErrorException */
    public function checkCount(OrderProduct $orderProduct, int $count): bool
    {
        if ($orderProduct->quantity < $count) {
            throw new ApiErrorException('Not enough quantity!', 403);
        }
        return true;
    }

    public function refundOrder(User $user, Order $order): RefundOrder
    {
        /** @var RefundOrder $refundOrder */
        $refundOrder = $this->refundOrderRepository->updateOrCreate([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'department_id' => $order->department_id,
        ], [
            'currency' => $order->currency,
            'shipping_data' => $order->shipping_data,
        ]);
        return $refundOrder;
    }

    public function refundOrderProduct(
        RefundOrder $refundOrder,
        OrderProduct $orderProduct,
        array $data
    ): RefundOrderProduct {

        /** @var RefundOrderProduct $refundOrderProduct */
        $refundOrderProduct = $this->refundOrderProductRepository->updateOrCreate([
            'refund_order_id' => $refundOrder->id,
        ], [
            'product_id' => $orderProduct->product_id,
            'quantity' => $data['quantity'],
            'price' => $orderProduct->price,
        ]);
        return $refundOrderProduct;
    }
}
