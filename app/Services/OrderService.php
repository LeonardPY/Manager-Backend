<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\AccessDeniedException;
use App\Exceptions\ApiErrorException;
use App\Http\Filters\OrderFilter;
use App\Models\Order;
use App\Models\User;
use App\Repositories\UserAddressRepositoryInterface;
use App\Services\ExchangeRate\ExchangeRateService;
use App\Services\Order\OrderProductService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Throwable;

readonly class OrderService
{
    public function __construct(
        private UserAddressRepositoryInterface $userAddressRepository,
        private ExchangeRateService $exchangeRateService,
        private OrderProductService $orderProductService,
    ) {
    }

    /** @throws BindingResolutionException */
    public function makeFilter(array $validatedArray): OrderFilter
    {
        $filterData = $validatedArray;
        if (!isset($validatedArray['status'])) {
            $filterData = array_merge($validatedArray, [
                'status' => OrderStatus::IN_CART->value
            ]);
        }
        return app()->make(OrderFilter::class, ['queryParams' => $filterData]);
    }

    /** @throws ApiErrorException|Throwable */
    public function makeOrderProduct(User $user, array $data): Order
    {
        return $this->orderProductService->makeOrder($user, $data);
    }

    public function calculate(Order $order): array
    {
        $order->refresh();

        $curse = $this->exchangeRateService->getExchangeRate(
            from: $order->department->country->currency,
            to: $order->currency
        );

        $amount = 0;
        $shippingCost = 0.00;
        $insuranceCost = 0.00;

        foreach ($order->orderProducts as $orderProduct) {
            $amount += $orderProduct->price * $curse * $orderProduct->quantity;
        }

        return [
            'price' => round($amount, 2),
            'payment_amount' => round($amount + $shippingCost + $insuranceCost, 2),
            'shipping_cost' => round((float)$shippingCost, 2),
            'currency' => $order->currency,
        ];
    }

    public function userAddresses(array $data): array
    {
        if (isset($data['user_address_id'])) {
            $shipping = $this->userAddressRepository->getAddressById($data['user_address_id']);
            $data['shipping_data'] = $shipping->toArray();
        }
        return $data;
    }

    /** @throws AccessDeniedException */
    public function haveProcessAccess(Order $order, int $userId): void
    {
        if (!$order->haveProcessAccess($userId)) {
            throw new AccessDeniedException();
        }
    }

    /** @throws ApiErrorException */
    public function checkWhenConfirmOrder(Order $order): void
    {
        if (!$order->user_address_id) {
            throw new ApiErrorException(trans('message.address_not_found'));
        }
    }

    /** @throws ApiErrorException */
    public function workerHasAccess(User $user, Order $order): void
    {
        if ($order->department_id !== $user->worker->organization_id) {
            throw new ApiErrorException(trans('message.address_not_found'));
        };
    }
}
