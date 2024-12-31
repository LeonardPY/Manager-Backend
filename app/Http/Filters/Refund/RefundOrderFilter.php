<?php

namespace App\Http\Filters\Refund;

use App\Http\Filters\AbstractFilters;
use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class RefundOrderFilter extends AbstractFilters
{
    use FilterHasPagination;
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
