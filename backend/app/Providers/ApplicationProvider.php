<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApplicationProvider extends ServiceProvider
{
    /**
     * Register services.
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
        $this->app->bind(
            \Package\Usecase\Account\UpdateAvator\AccountUpdateAvatorServiceInterface::class,
            \Package\Application\Account\UpdateAvator\AccountUpdateAvatorService::class
        );
        $this->app->bind(
            \Package\Usecase\Account\DeleteAvator\AccountDeleteAvatorServiceInterface::class,
            \Package\Application\Account\DeleteAvator\AccountDeleteAvatorService::class
        );
        $this->app->bind(
            \Package\Usecase\Account\ChangeProfile\AccountChangeProfileServiceInterface::class,
            \Package\Application\Account\ChangeProfile\AccountChangeProfileService::class
        );
        $this->app->bind(
            \Package\Usecase\Account\Withdrawal\AccountWithdrawalServiceInterface::class,
            \Package\Application\Account\Withdrawal\AccountWithdrawalService::class
        );
        $this->app->bind(
            \Package\Usecase\Game\GamePackage\GetList\GamePackageListServiceInterface::class,
            \Package\Application\Game\GamePackage\GetList\GamePackageListService::class
        );
        $this->app->bind(
            \Package\Usecase\Game\GameMap\GetList\GameMapListServiceInterface::class,
            \Package\Application\Game\GameMap\GetList\GameMapListService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
