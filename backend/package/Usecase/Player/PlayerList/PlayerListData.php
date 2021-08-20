<?php

namespace Package\Usecase\Player\PlayerList;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class PlayerListData extends Data {
  public $players;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'id' => $source->getPlayerId()->getValue(),
        'gamePackageId' => $source->getGamePackageId()->getValue(),
        'name' => $source->getPlayerName()->getValue(),
        'avatorImage' => $source->getUser()->getAvatorImage()->getImageFullPath(),
        'rate' => $source->getRate()->getValue(),
        'rank' => $source->getMu()->getRank(),
        'sigma' => $source->getSigma()->getValue(),
        'win' => $source->getWin()->getValue(),
        'defeat' => $source->getDefeat()->getValue(),
        'draw' => $source->getGameDraw(),
        'games' => $source->getGames()->getValue(),
        'wp' => $source->getGameWinningPercentageWithPer(),
        'enabled' => $source->getEnabled()->getValue(),
      ];
    }
    $this->players = $response;
  }
}