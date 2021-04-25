<?php

namespace Package\Usecase\Player\GetList;

use Package\Domain\User\Entity\Player;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class PlayerData extends Data {
  public $players;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'id' => $source->getPlayerId()->getValue(),
        'name' => $source->getPlayerName()->getValue(),
        'rate' => $source->getRate()->getValue(),
        'rank' => $source->getMu()->getRank(),
        'sigma' => $source->getSigma()->getValue(),
        'win' => $source->getWin()->getValue(),
        'defeat' => $source->getDefeat()->getValue(),
        'draw' => $source->getGameDraw(),
        'games' => $source->getGames()->getValue(),
        'wp' => $source->getGameWinningPercentageWithPer(),
        'gamePackages' => $source->getGamePackages()->getList(),
        'enabled' => $source->getEnabled()->getValue(),
      ];
    }
    $this->players = $response;
  }
}