<?php

namespace App\Http\Filters\FilterTraits;

use Illuminate\Database\Eloquent\Builder;

trait FilterHasPagination
{
    public const PAGE = 'page';
    public const LIMIT = 'limit';

    public int $PAGE = 1;
    public int $LIMIT = 25;

    public function limit(Builder $builder, int $value): void
    {
        $this->LIMIT = $value;
    }

    public function page(Builder $builder, int $value): void
    {
        $this->PAGE = $value;
    }
}
