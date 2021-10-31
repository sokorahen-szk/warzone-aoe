<?php declare(strict_types=1);

namespace Package\Usecase\Game\Finished;

interface GameFinishedServiceInterface
{
    public function handle(GameFinishedCommand $command): void;
}
