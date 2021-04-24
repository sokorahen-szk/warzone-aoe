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
        'mu' => $source->getMu()->getValue(),
        'sigma' => $source->getSigma()->getValue(),
        'minRate' => $source->getMinRate()->getValue(),
        'maxRate' => $source->getMaxRate()->getValue(),
        'win' => $source->getWin()->getValue(),
        'defeat' => $source->getDefeat()->getValue(),
        'draw' => $source->getGameDraw(),
        'games' => $source->getGames()->getValue(),
        'wp' => $source->getGameWinningPercentage(),
        'gamePackages' => $source->getGamePackages()->getList(),
        'joinedAt' => $source->getJoinedAt()->getDatetime(),
        'lastGameAt' => $source->getLastGameAt()->getDatetime(),
        'enabled' => $source->getEnabled()->getValue(),
      ];
    }
    $this->players = $response;
  }
}