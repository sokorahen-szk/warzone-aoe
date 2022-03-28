<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

use Package\Usecase\Game\GameHistory\GetList\GameHistoryListData;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListCommand;

interface GameHistoryListServiceInterface
{
    public function handle(GameHistoryListCommand $command): ?GameHistoryListData;
}
