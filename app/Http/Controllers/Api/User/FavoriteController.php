<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Favorite\SaveFavoritesRequest;
use App\Http\Requests\User\Favorite\StoreFavoriteRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserFavoriteResource;
use App\Models\Favorite;
use App\Repositories\FavoriteRepositoryInterface;
use App\Services\User\UserFavoriteService;
use Illuminate\Support\Facades\Gate;

final class FavoriteController extends Controller
{
    public function __construct(
        private readonly FavoriteRepositoryInterface $favoriteRepository,
        private readonly UserFavoriteService         $favoriteService
    )
    {
    }

    public function index(): PaginationResource
    {
        $favorites = $this->favoriteRepository->getFavoritesByUser(auth()->id());
        return PaginationResource::make([
            'data' => UserFavoriteResource::collection($favorites),
            'pagination' => $favorites
        ]);
    }

    public function store(StoreFavoriteRequest $request): SuccessResource
    {
        $data = $request->validated();
        $this->favoriteRepository->updateOrCreate($data + ['user_id' => auth()->id()], []);
        return SuccessResource::make([
            'message' => 'successfully created'
        ]);
    }

    public function destroy(Favorite $favorite): ErrorResource|SuccessResource
    {
        if (Gate::forUser(auth()->user())->allows('authorize', $favorite)) {
            $favorite->delete();

            return new SuccessResource([
                'message' => 'successfully deleted!',
            ]);
        }
        return ErrorResource::make([
            'message' => 'Access Denied'
        ]);
    }

    public function saveFavorites(SaveFavoritesRequest $request): SuccessResource
    {
        $favorites = $this->favoriteService->makeStoreData($request->validated());

        foreach ($favorites as $favorite) {
            $this->favoriteRepository->updateOrCreate(['user_id' => auth()->id(), 'product_id' => $favorite['product_id']], []);
        }

        return SuccessResource::make([
            'massage' => 'successfully save!'
        ]);
    }
}
