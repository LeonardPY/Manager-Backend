<?php

declare(strict_types=1);

namespace App\Services\User;

class UserFavoriteService
{

    public function makeStoreData(array $favorites): array
    {
        $saveFavoritesData = [];
        foreach ($favorites['favorites'] as $favorite) {
            $saveFavoritesData[]  = [
                'user_id' => auth()->id(),
                'product_id' => $favorite['product_id']
            ];
        }
        return $saveFavoritesData;
    }
}
