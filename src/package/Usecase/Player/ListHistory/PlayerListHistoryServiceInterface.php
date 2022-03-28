<?php declare(strict_types=1);

namespace Package\Usecase\Player\ListHistory;

interface PlayerListHistoryServiceInterface
{
    public function handle(PlayerListHistoryCommand $command): PlayerListHistoryData;
}
