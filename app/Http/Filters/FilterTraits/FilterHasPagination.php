<?php

namespace App\Http\Filters\FilterTraits;

use Illuminate\Database\Eloquent\Builder;

trait FilterHasPagination
{
    public const PER_PAGE = 'limit';
    public const PAGE = 'page';

    public int $PAGE = 1;
    public int $PER_PAGE = 25;

    public function page(Builder $builder, int $value): void
    {
        $this->PAGE = $value;
    }
    public function limit(Builder $builder, int $value): void
    {
        $this->PER_PAGE = $value;
    }
}
