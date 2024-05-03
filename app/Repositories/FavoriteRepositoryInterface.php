<?php

declare(strict_types=1);

namespace App\Repositories;

interface FavoriteRepositoryInterface extends BaseRepositoryInterface
{
    public function getFavoritesByUser(int $userId): object;

    public function isProductInFavorites(int $userId, int $productId): bool;

    public function insertOrIgnore(array $data): int;
}
