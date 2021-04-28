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
            \Package\Usecase\Account\Register\AccountRegisterServiceInterface::class,
            \Package\Application\Account\Register\AccountRegisterService::class
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
        $this->app->singleton(
            \Package\Domain\User\Repository\RegisterRequestRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\User\RegisterRequestRepository::class
        );

        /**
         * Services...
         */
        $this->app->bind(
            \Package\Domain\User\Service\UserServiceInterface::class,
            \Package\Domain\User\Service\UserService::class
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
