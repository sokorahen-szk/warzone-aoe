<?php declare(strict_types=1);

namespace Package\Usecase\Admin\Game\Update;

class AdminGameUpdateCommand {
  public $gameRecordId;
  public $status;
  public $winningTeam;

  public function __construct(
    int $gameRecordId,
    int $status,
    ?int $winningTeam
  )
  {
    $this->gameRecordId = $gameRecordId;
    $this->status = $status;
    $this->winningTeam = $winningTeam;
  }
}