<?php declare(strict_types=1);

namespace Package\Usecase\Player\GetProfile;

use Package\Usecase\Player\GetProfile\PlayerGetProfileData;
use Package\Usecase\Player\GetProfile\PlayerGetProfileCommand;

interface PlayerGetProfileServiceInterface
{
    public function handle(PlayerGetProfileCommand $command): PlayerGetProfileData;
}
