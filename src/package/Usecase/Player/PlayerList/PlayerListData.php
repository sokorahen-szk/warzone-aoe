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
        'userId' => $source->getUser()->getId()->getValue(),
        'avatorImage' => $source->getUser()->getAvatorImage()->getImageFullPath(),
        'name' => $source->getPlayerName()->getValue(),
        'rate' => $source->getRate()->getValue(),
        'mu' => $source->getMu()->getValueAsInt(),
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