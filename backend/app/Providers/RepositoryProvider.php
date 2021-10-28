<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
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
        $this->app->singleton(
            \Package\Domain\Game\Repository\GamePackageRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Game\GamePackageRepository::class
        );
        $this->app->singleton(
            \Package\Domain\Game\Repository\GameMapRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Game\GameMapRepository::class
        );
        $this->app->singleton(
            \Package\Domain\Game\Repository\GameRecordRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Game\GameRecordRepository::class
        );
        $this->app->singleton(
            \Package\Domain\Game\Repository\GameRuleRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Game\GameRuleRepository::class
        );
        $this->app->singleton(
            \Package\Domain\User\Repository\PlayerMemoryRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Player\PlayerMemoryRepository::class
        );
        $this->app->singleton(
            \Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface::class,
            \Package\Infrastructure\Eloquent\Game\GameRecordTokenRepository::class
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
