<?php

namespace App\Providers;

//Repository
use App\Repositories\Eloquent\FavoriteRepository;
use App\Repositories\Eloquent\OrderProductRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ProductDescriptionRepository;
use App\Repositories\Eloquent\ProductPictureRepository;
use App\Repositories\Eloquent\RefundOrderProductRepository;
use App\Repositories\Eloquent\RefundOrderRepository;
use App\Repositories\Eloquent\ResetPasswordRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ProductMainPictureRepository;
use App\Repositories\Eloquent\UserAddressRepository;

//Interface
use App\Repositories\FavoriteRepositoryInterface as FavoriteRepositoryContract;
use App\Repositories\OrderProductRepositoryInterface as OrderProductRepositoryContract;
use App\Repositories\OrderRepositoryInterface as OrderRepositoryContract;
use App\Repositories\ProductDescriptionRepositoryInterface as ProductDescriptionRepositoryContract;
use App\Repositories\ProductPictureRepositoryInterface as ProductPictureRepositoryContract;
use App\Repositories\RefundOrderProductRepositoryInterface;
use App\Repositories\RefundOrderRepositoryInterface;
use App\Repositories\ResetPasswordRepositoryInterface as ResetPasswordRepositoryContract;
use App\Repositories\UserRepositoryInterface as UserRepositoryContract;
use App\Repositories\CategoryRepositoryInterface as CategoryRepositoryContract;
use App\Repositories\ProductRepositoryInterface as ProductRepositoryContract;
use App\Repositories\ProductMainPictureRepositoryInterface as ProductMainPictureRepositoryContract;
use App\Repositories\UserAddressRepositoryInterface as UserAddressRepositoryContract;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /** Register services.*/
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductMainPictureRepositoryContract::class, ProductMainPictureRepository::class);
        $this->app->bind(UserAddressRepositoryContract::class, UserAddressRepository::class);
        $this->app->bind(ProductDescriptionRepositoryContract::class, ProductDescriptionRepository::class);
        $this->app->bind(ProductPictureRepositoryContract::class, ProductPictureRepository::class);
        $this->app->bind(FavoriteRepositoryContract::class, FavoriteRepository::class);
        $this->app->bind(ResetPasswordRepositoryContract::class, ResetPasswordRepository::class);
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(OrderProductRepositoryContract::class, OrderProductRepository::class);
        $this->app->bind(RefundOrderRepositoryInterface::class, RefundOrderRepository::class);
        $this->app->bind(RefundOrderProductRepositoryInterface::class, RefundOrderProductRepository::class);
    }

    /** Bootstrap services */
    public function boot(): void
    {
        //
    }
}
