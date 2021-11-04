<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Services...
         */
        $this->app->bind(
            \Package\Domain\User\Service\UserServiceInterface::class,
            \Package\Domain\User\Service\UserService::class
        );

        $this->app->bind(
            \Package\Domain\User\Service\PlayerServiceInterface::class,
            \Package\Domain\User\Service\PlayerService::class
        );

        $this->app->bind(
            \Package\Domain\Game\Service\GameRecordServiceInterface::class,
            \Package\Domain\Game\Service\GameRecordService::class
        );

        $this->app->bind(
            \Package\Infrastructure\Discord\DiscordClientInterface::class,
            \Package\Infrastructure\Discord\DiscordClient::class
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
