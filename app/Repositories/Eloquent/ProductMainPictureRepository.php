<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductMainPicture;
use App\Repositories\ProductMainPictureRepositoryInterface;

final class ProductMainPictureRepository extends BaseRepository implements ProductMainPictureRepositoryInterface
{

    public function __construct(ProductMainPicture $model)
    {
        parent::__construct($model);
    }
}
