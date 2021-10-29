<?php declare(strict_types=1);

namespace Package\Usecase\Game\Finished;

class GameFinishedCommand {
  public $token;

  public function __construct(
    string $token
  )
  {
    $this->token = $token;
  }
}