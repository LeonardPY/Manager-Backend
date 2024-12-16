<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\AccessDeniedException;
use App\Models\Order;
use App\Repositories\UserAddressRepositoryInterface;
use App\Services\ExchangeRate\ExchangeRateService;
readonly class OrderService
{
    public function __construct(
        private UserAddressRepositoryInterface $userAddressRepository,
        private ExchangeRateService $exchangeRateService
    ) {
    }

    public function calculate(Order $order): array
    {
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

    /**
     * @throws AccessDeniedException
     */
    public function haveProcessAccess(Order $order, int $userId): void
    {
        if (!$order->haveProcessAccess($userId)) {
            throw new AccessDeniedException();
        }
    }
}
