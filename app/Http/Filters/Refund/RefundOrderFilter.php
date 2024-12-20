<?php

namespace App\Http\Filters\Refund;

use App\Http\Filters\AbstractFilters;
use App\Http\Filters\Trait\PaginationFilter;
use Illuminate\Database\Eloquent\Builder;

class RefundOrderFilter extends AbstractFilters
{
    use PaginationFilter;
    public const STATUS = 'status';
    protected function getCallbacks(): array
    {
        return [
            self::STATUS  => [$this, 'status'],
            self::PAGE  => [$this, 'page'],
            self::LIMIT => [$this, 'limit'],
        ];
    }

    public function status(Builder $builder, int $value): void
    {
        $builder->where('status', $value);
    }
}
