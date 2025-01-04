<?php

namespace App\Http\Filters\Worker;

use App\Http\Filters\AbstractFilters;
use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class WorkerFilter extends AbstractFilters
{
    use FilterHasPagination;
    public const NAME = 'name';
    protected function getCallbacks(): array
    {
        return [
            self::NAME        => [$this, 'name'],
            self::PAGE  => [$this, 'page'],
            self::LIMIT => [$this, 'limit'],
        ];
    }

    public function name(Builder $builder, string $value): void
    {
        $builder->where('name', 'like', "%$value%");
    }
}
