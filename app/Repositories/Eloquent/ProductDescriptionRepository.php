<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductDescription;
use App\Repositories\ProductDescriptionRepositoryInterface;

final class ProductDescriptionRepository extends BaseRepository implements ProductDescriptionRepositoryInterface
{
    public function __construct(ProductDescription $model)
    {
        parent::__construct($model);
    }
}
