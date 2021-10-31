<?php declare(strict_types=1);

namespace Package\Usecase\Game\Finished;

class GameFinishedCommand {
  public $token;
  public $status;
  public $winningTeam;

  public function __construct(
    string $token,
    int $status,
    ?int $winningTeam
  )
  {
    $this->token = $token;
    $this->status = $status;
    $this->winningTeam = $winningTeam;
  }
}