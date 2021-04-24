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
        /**
         * Applications...
         */
        $this->app->bind(
            \Package\Usecase\Account\GetInfo\AccountGetInfoServiceInterface::class,
            \Package\Application\Account\GetInfo\AccountGetInfoService::class
        );
        $this->app->bind(
            \Package\Usecase\Player\GetList\PlayerGetListServiceInterface::class,
            \Package\Application\Player\GetList\PlayerGetListService::class
        );

        /**
         * Repositories...
         */
        $this->app->singleton(
            \Package\Domain\User\Repository\UserRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\User\UserRepository::class
        );
        $this->app->singleton(
            \Package\Domain\User\Repository\PlayerRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Player\PlayerRepository::class
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
