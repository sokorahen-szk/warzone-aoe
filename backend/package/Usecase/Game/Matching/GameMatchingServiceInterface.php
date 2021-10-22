<?php declare(strict_types=1);

namespace Package\Usecase\Game\Matching;

interface GameMatchingServiceInterface
{
    public function handle(GameMatchingCommand $command): void;
}
