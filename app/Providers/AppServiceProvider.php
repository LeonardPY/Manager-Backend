<?php

namespace App\Providers;

use App\Exceptions\Handler;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExceptionHandlerContract::class, Handler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('authorize', function (object $user, object $userRelativeObject) {
            return $user->id === $userRelativeObject->user_id;
        });
    }
}
