<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\RefundOrderProduct;
use App\Repositories\RefundOrderProductRepositoryInterface;

final class RefundOrderProductRepository extends BaseRepository implements RefundOrderProductRepositoryInterface
{
    public function __construct(RefundOrderProduct $model)
    {
        parent::__construct($model);
    }
}
