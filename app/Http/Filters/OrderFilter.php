<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends AbstractFilters
{
    public const ORDER_STATUS = 'status';

    protected function getCallbacks(): array
    {
        return [
            self::ORDER_STATUS  => [$this, 'status'],
        ];
    }

    public function status(Builder $builder, int $value): void
    {
        $builder->where('status', $value);
    }
}
