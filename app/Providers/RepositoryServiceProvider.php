<?php

namespace App\Providers;

//Repository
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ProductMainPictureRepository;
use App\Repositories\Eloquent\UserAddressRepository;

//Interface
use App\Repositories\UserRepositoryInterface as UserRepositoryContract;
use App\Repositories\CategoryRepositoryInterface as CategoryRepositoryContract;
use App\Repositories\ProductRepositoryInterface as ProductRepositoryContract;
use App\Repositories\ProductMainPictureRepositoryInterface as ProductMainPictureRepositoryContract;
use App\Repositories\UserAddressRepositoryInterface as UserAddressRepositoryContract;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductMainPictureRepositoryContract::class, ProductMainPictureRepository::class);
        $this->app->bind(UserAddressRepositoryContract::class, UserAddressRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('authorize', function (object $user, object $userRelObject) {
            return $user->id === $userRelObject->user_id;
        });
    }
}
