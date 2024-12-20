<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Filters\Refund\RefundOrderFilter;
use Illuminate\Pagination\LengthAwarePaginator;

interface RefundOrderRepositoryInterface extends BaseRepositoryInterface
{
    public function filterRefundOrderByStoreId(int $userId, RefundOrderFilter $filter): LengthAwarePaginator;

    public function filterRefundOrderByFactoryId(int $userId, RefundOrderFilter $filter): LengthAwarePaginator;
}
