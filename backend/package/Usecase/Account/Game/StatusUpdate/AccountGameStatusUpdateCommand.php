<?php declare(strict_types=1);

namespace Package\Usecase\Account\Game\StatusUpdate;

class AccountGameStatusUpdateCommand {
  public $userId;
  public $gameRecordId;
  public $status;
  public $winningTeam;

  public function __construct(
    int $userId,
    int $gameRecordId,
    int $status,
    ?int $winningTeam
  )
  {
    $this->userId = $userId;
    $this->gameRecordId = $gameRecordId;
    $this->status = $status;
    $this->winningTeam = $winningTeam;
  }
}