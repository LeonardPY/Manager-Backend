<?php

namespace App\Http\Filters;

use App\Http\Filters\FilterTraits\FilterHasPagination;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilters
{
    use FilterHasPagination;
    public const  NAME = 'name';
    public const  NAME_AM = 'name_am';
    public const  CATEGORY = 'category';
    public const  BRAND_ID = 'brand_id';
    public const  PRICE_FROM = 'price_from';
    public const  PRICE_TO = 'price_to';
    public int $PER_PAGE = 25;

    protected function getCallbacks(): array
    {
        return [
            self::NAME       => [$this, 'name'],
            self::NAME_AM    => [$this, 'name_am'],
            self::CATEGORY   => [$this, 'category'],
            self::BRAND_ID   => [$this, 'brandId'],
            self::PRICE_FROM => [$this, 'priceFrom'],
            self::PRICE_TO   => [$this, 'priceTo'],
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

    public function category(Builder $builder, object $value): void
    {
        $builder->whereHas('category', function ($query) use ($value) {
            $query->whereIn('categories.id', $value->descendantsAndSelf()->select('id')->getQuery()->pluck('id')->toArray());
        });
    }

    public function brandId(Builder $builder, string $value): void
    {
        $builder->whereIn('brand_id', $value);
    }

    public function priceFrom(Builder $builder, int $value): void
    {
        $builder->where('price', '>=', $value);
    }

    public function priceTo(Builder $builder, int $value): void
    {
        $builder->where('price', '<=', $value);
    }

    public function perPage(Builder $builder, int $value)
    {
        $this->PER_PAGE = $value;
    }
}
