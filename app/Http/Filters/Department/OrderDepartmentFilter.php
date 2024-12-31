<?php

namespace App\Http\Filters\Department;

use App\Http\Filters\AbstractFilters;
use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class
OrderDepartmentFilter extends AbstractFilters
{
    use FilterHasPagination;
    public const ORDER_STATUS = 'status';

    public const NAME = 'name';

    protected function getCallbacks(): array
    {
        return [
            self::ORDER_STATUS  => [$this, 'status'],
            self::NAME  => [$this, 'name'],
            self::PAGE  => [$this, 'page'],
            self::LIMIT => [$this, 'limit'],
        ];
    }

    public function status(Builder $builder, int $value): void
    {
        $builder->where('status', $value);
    }

    public function name(Builder $builder, string $value): void
    {
        $builder->whereHas('user', function (Builder $builder) use ($value) {
            $builder->where('name', 'like', '%' . $value . '%');
        });
    }
}
