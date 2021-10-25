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
            \Package\Usecase\Player\PlayerList\PlayerListServiceInterface::class,
            \Package\Application\Player\PlayerList\PlayerListService::class
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
        $this->app->bind(
            \Package\Usecase\Admin\RegisterRequest\GetList\AdminRegisterRequestGetListServiceInterface::class,
            \Package\Application\Admin\RegisterRequest\GetList\AdminRegisterRequestGetListService::class
        );
        $this->app->bind(
            \Package\Usecase\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateServiceInterface::class,
            \Package\Application\Admin\RegisterRequest\Update\AdminRegisterRequestUpdateService::class
        );
        $this->app->bind(
            \Package\Usecase\Game\GameRecord\GetList\GameRecordListByDateRangeServiceInterface::class,
            \Package\Application\Game\GameRecord\GetList\GameRecordListByDateRangeService::class
        );
        $this->app->bind(
            \Package\Usecase\Player\GetProfile\PlayerGetProfileServiceInterface::class,
            \Package\Application\Player\GetProfile\PlayerGetProfileService::class
        );
        $this->app->bind(
            \Package\Usecase\Game\GameHistory\GetList\GameHistoryListServiceInterface::class,
            \Package\Application\Game\GameHistory\GetList\GameHistoryListService::class
        );
        $this->app->bind(
            \Package\Usecase\Player\ListHistory\PlayerListHistoryServiceInterface::class,
            \Package\Application\Player\ListHistory\PlayerListHistoryService::class
        );
        $this->app->bind(
            \Package\Usecase\Game\TeamDivision\GameTeamDivisionServiceInterface::class,
            \Package\Application\Game\TeamDivision\GameTeamDivisionService::class
        );
        $this->app->bind(
            \Package\Usecase\Game\Matching\GameMatchingServiceInterface::class,
            \Package\Application\Game\Matching\GameMatchingService::class
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
