<?php

namespace App\Http\Filters;

use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilters
{
    use FilterHasPagination;
    public const NAME = 'name';
    public const LAST_NAME = 'last_name';

    protected function getCallbacks(): array
    {
        return [
            self::NAME        => [$this, 'name'],
            self::LAST_NAME   => [$this, 'last_name'],

            self::PAGE        => [$this, 'page'],
            self::PER_PAGE    => [$this, 'limit'],
        ];
    }

    public function name(Builder $builder, string $value): void
    {
        $builder->where('name', 'like', "%$value%");
    }
    public function last_name(Builder $builder, string $value): void
    {
        $builder->where('name_am', 'like', "%$value%");
    }
}
