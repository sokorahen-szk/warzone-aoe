<?php declare(strict_types=1);

namespace Package\Usecase\Player\GetProfile;

class PlayerGetProfileCommand
{
    public $userId;

    public function __construct(int $userId) {
        $this->userId = $userId;
    }
}
