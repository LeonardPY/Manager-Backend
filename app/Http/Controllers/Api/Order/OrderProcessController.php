<?php

namespace App\Http\Controllers\Api\Order;

use App\Enums\OrderStatus;
use App\Exceptions\AccessDeniedException;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Mail\Order\OrderConfirmMail;
use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;
use App\Services\OrderService;
use Illuminate\Support\Facades\Mail;

class OrderProcessController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderProductRepository,
        private readonly OrderService $orderService,
    ) {
    }

    /** @throws ApiErrorException|AccessDeniedException */
    public function confirmOrder(Order $order): SuccessResource
    {
        $this->orderService->haveProcessAccess($order, authUser()->id);
        $this->orderService->checkWhenConfirmOrder($order);
        $this->orderProductRepository->update($order->id, ['status' => OrderStatus::PENDING->value]);
        Mail::to($order->department->email)->send(new OrderConfirmMail($order));
        return SuccessResource::make([
            'message' => trans('message.successfully_confirmed')
        ]);
    }

    /**
     * Worker Shipped Order
     * @throws ApiErrorException
     */
    public function workerOrderShipped(Order $order): SuccessResource
    {
        $this->orderService->workerHasAccess(authUser(), $order);
        $this->orderProductRepository->update($order->id, ['status' => OrderStatus::DELIVERED->value]);
        return SuccessResource::make([
            'message' => trans('message.successfully_confirmed')
        ]);
    }
}
