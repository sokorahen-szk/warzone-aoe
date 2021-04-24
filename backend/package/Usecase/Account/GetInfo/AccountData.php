<?php

namespace Package\Usecase\Account\GetInfo;

use Package\Domain\User\Entity\User;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AccountData extends Data {
  public $id;
  public $player;
  public $name;
  public $twitterId;
  public $avatorImage;
  public $email;
  public $role;

  public function __construct(User $source)
  {
    $this->id = $source->getId()->getValue();
    $this->name = $source->getName()->getValue();
    $this->twitterId = $source->getTwitterId()->getValue();
    $this->avatorImage = $source->getAvatorImage()->getValue();
    $this->email = $source->getEmail()->getValidEmail();

    $this->player = [
      'id' => $source->getPlayer()->getPlayerId()->getValue(),
      'name' => $source->getPlayer()->getPlayerName()->getValue(),
      'mu' => $source->getPlayer()->getMu()->getValue(),
      'sigma' => $source->getPlayer()->getSigma()->getValue(),
      'minRate' => $source->getPlayer()->getMinRate()->getValue(),
      'maxRate' => $source->getPlayer()->getMaxRate()->getValue(),
      'win' => $source->getPlayer()->getWin()->getValue(),
      'defeat' => $source->getPlayer()->getDefeat()->getValue(),
      'draw' => $source->getPlayer()->getGameDraw(),
      'games' => $source->getPlayer()->getGames()->getValue(),
      'wp' => $source->getPlayer()->getGameWinningPercentage(),
      'gamePackages' => $source->getPlayer()->getGamePackages()->getList(),
      'joinedAt' => $source->getPlayer()->getJoinedAt()->getValue(),
      'lastGameAt' => $source->getPlayer()->getLastGameAt()->getValue(),
      'enabled' => $source->getPlayer()->getEnabled()->getValue(),
    ];

    $this->role = [
      'id' => $source->getRole()->getRoleId()->getValue(),
      'name' => $source->getRole()->getRoleName()->getValue(),
      'level' => $source->getRole()->getRoleLevel()->getValue(),
    ];
  }
}