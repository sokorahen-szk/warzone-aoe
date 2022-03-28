<?php declare(strict_types=1);

namespace Package\Usecase\Admin\Player\Update;

class AdminPlayerUpdateCommand {
  public $playerId;
  public $playerName;
  public $mu;
  public $sigma;
  public $rate;
  public $enabled;

  public function __construct(
    int $playerId,
    string $playerName,
    float $mu,
    float $sigma,
    int $rate,
    bool $enabled
  )
  {
    $this->playerId = $playerId;
    $this->playerName = $playerName;
    $this->mu = $mu;
    $this->sigma = $sigma;
    $this->rate = $rate;
    $this->enabled = $enabled;
  }
}