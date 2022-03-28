<?php declare(strict_types=1);

namespace Package\Usecase\Game\Matching;

use Package\Domain\Game\Entity\GameRecordToken;
use Package\Usecase\Data;

class GameMatchingData extends Data {
  public $gameRecordId;
  public $gameToken;

  public function __construct(GameRecordToken $source)
  {
    $this->gameRecordId = $source->getGameRecordId()->getValue();
    $this->gameToken = $source->getGameToken()->getValue();
  }
}