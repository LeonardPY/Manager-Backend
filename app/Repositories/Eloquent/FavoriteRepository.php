<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\ProductStatusEnum;
use App\Models\Favorite;
use App\Repositories\FavoriteRepositoryInterface;

final class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }

    public function getFavoritesByUser(int $userId): object
    {
        return $this->model->with('product.mainPicture')
            ->whereHas('product', function ($query) {
                return $query->where('status', ProductStatusEnum::PUBLIC->value);
            })
            ->where('user_id', $userId)->paginate(25);
    }

    public function isProductInFavorites(int $userId, int $productId): bool
    {
        return $this->model::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public function insertOrIgnore(array $data): int
    {
        return $this->model->insertOrIgnore($data);
    }
}
