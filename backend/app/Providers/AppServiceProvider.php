<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface::class,
            \Package\Application\Account\GetInfo\AccountGetInfoService::class
        );

        $this->app->singleton(
            \Package\Domain\User\Repository\UserRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\User\UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
