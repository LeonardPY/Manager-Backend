<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Enums\OrderStatus;
use App\Exceptions\ApiErrorException;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Throwable;

readonly class OrderProductService
{
    public function __construct(
        private  OrderRepositoryInterface $orderRepository,
        private  OrderProductRepositoryInterface $orderProductRepository,
        private  ProductRepositoryInterface $productRepository,
        private DatabaseManager $databaseManager
    ) {
    }

    /** @throws ApiErrorException|Throwable */
    public function makeOrder(User $user, array $data): Order
    {
        $quantity = $data['quantity'] ?? 1;


        if (!isset($data['product_id'])) {
            throw new ApiErrorException(
                trans('message.invalid_product'), 400
            );
        }
        $product = $this->productRepository->findOrFail($data['product_id']);
        $this->checkStock($product, $quantity);
        return $this->databaseManager->transaction(function () use ($user, $product, $quantity): Order {
            $order = $this->updateOrCreateOrder($user, $product);
            $this->updateOrCreateOrderProduct($order, $product, $quantity);
            return $order;
        });
    }

    protected function updateOrCreateOrder(User $user, Product $product): Order
    {
        return $this->orderRepository->updateOrCreate([
            'user_id' => $user->id,
            'department_id' => $product->user_id,
            'status' => OrderStatus::IN_CART->value,
        ], []);
    }

    protected function updateOrCreateOrderProduct(Order $order, Product $product, int $quantity): void
    {
        $this->orderProductRepository->updateOrCreate([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ], [
            'quantity' => $quantity,
            'price' => $product->price,
            'discount_percent' => $product->discount_percent,
        ]);
    }

    /** @throws ApiErrorException */
    public function checkStock(Product $product, int $quantity): true
    {
        if ($product->count < $quantity) {
            throw new ApiErrorException(
                trans('message.product_out_of_stock',
                    ['product' => $product->name]
                ), 422);
        }
        return true;
    }
}
