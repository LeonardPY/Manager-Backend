<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Filters\Refund\RefundOrderFilter;
use App\Models\RefundOrder;
use App\Repositories\RefundOrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class RefundOrderRepository extends BaseRepository implements RefundOrderRepositoryInterface
{
    public function __construct(RefundOrder $model)
    {
        parent::__construct($model);
    }

    public function filterRefundOrderByStoreId(int $userId, RefundOrderFilter $filter): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)->with('factory')
            ->filter($filter)->paginate($filter->LIMIT, '*', 'page', $filter->PAGE);
    }

    public function filterRefundOrderByFactoryId(int $userId, RefundOrderFilter $filter): LengthAwarePaginator
    {
        return $this->model->where('department_id', $userId)->with('store')
            ->filter($filter)->paginate($filter->LIMIT, '*', 'page', $filter->PAGE);
    }
}
