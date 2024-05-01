<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilters
{

    public const NAME = 'name';
    public const LAST_NAME = 'last_name';
    public const PER_PAGE = 'per_page';

    public int $PER_PAGE = 25;


    protected function getCallbacks(): array
    {
        return [
            self::NAME        => [$this, 'name'],
            self::LAST_NAME   => [$this, 'last_name'],
            self::PER_PAGE    => [$this, 'perPagePagination'],
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
    public function perPagePagination(Builder $builder, int $value): void
    {
        $this->PER_PAGE = $value;
    }

}
