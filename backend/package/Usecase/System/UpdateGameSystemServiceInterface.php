<?php declare(strict_types=1);

namespace Package\Usecase\System;

use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\System\ValueObject\Datetime;

interface UpdateGameSystemServiceInterface {
    public function handle(GameRecord $gameRecord, ?GameTeam $winningTeam, GameStatus $gameStatus, Datetime $currentDatetime): void;
}