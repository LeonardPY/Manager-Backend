<?php

declare(strict_types=1);

namespace App\Repositories;

interface OrderProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrderProductWithOrder(int $id);

    public function clearOrder(int $orderId): int|null;
}
