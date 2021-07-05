<?php declare(strict_types=1);

namespace Package\Usecase\Player\GetHistory;

interface PlayerGetHistoryServiceInterface
{
    public function handle(PlayerGetHistoryCommand $command): PlayerGetHistoryData;
}
