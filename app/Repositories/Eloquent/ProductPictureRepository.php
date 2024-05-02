<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductPicture;
use App\Repositories\ProductPictureRepositoryInterface;

final class ProductPictureRepository extends BaseRepository implements ProductPictureRepositoryInterface
{
    public function __construct(ProductPicture $model)
    {
        parent::__construct($model);
    }
}
