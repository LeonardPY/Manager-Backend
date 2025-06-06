<?php

namespace App\Http\Filters;

use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends AbstractFilters
{
    use FilterHasPagination;
    public const ORDER_STATUS = 'status';
    public const EXCEPT_ORDER = 'except';

    protected function getCallbacks(): array
    {
        return [
            self::ORDER_STATUS  => [$this, 'status'],
            self::EXCEPT_ORDER  => [$this, 'exceptOrderStatus'],
            self::PAGE  => [$this, 'page'],
            self::LIMIT => [$this, 'limit'],
        ];
    }

    public function status(Builder $builder, int $value): void
    {
        $builder->where('status', $value);
    }

    public function exceptOrderStatus(Builder $builder, int $value): void
    {
        $builder->where('stats', '!=', $value);
    }
}
