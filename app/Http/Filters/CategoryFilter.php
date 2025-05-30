<?php

namespace App\Http\Filters;

use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends AbstractFilters
{

    use FilterHasPagination;
    public const NAME = 'name';
    public const NAME_AM = 'name_am';

    public const PER_PAGE = 'per_page';

    public int $PER_PAGE = 25;

    protected function getCallbacks(): array
    {
        return [
            self::NAME    => [$this, 'name'],
            self::NAME_AM   => [$this, 'name_am'],
            self::PAGE  => [$this, 'page'],
            self::LIMIT => [$this, 'limit'],
        ];
    }

    public function name(Builder $builder, string $value): void
    {
        $builder->where('name', 'like', "%{$value}%");
    }
    public function name_am(Builder $builder, string $value): void
    {
        $builder->where('name_am', 'like', "%{$value}%");
    }

    public function perPage(Builder $builder, int $value): void
    {
        $this->PER_PAGE = $value;
    }
}
