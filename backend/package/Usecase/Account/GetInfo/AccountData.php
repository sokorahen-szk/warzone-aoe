<?php

namespace Package\Usecase\Account\GetInfo;

use Package\Domain\User\Entity\User;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AccountData extends Data {
  public $id;
  public $name;
  public $steamId;
  public $twitterId;
  public $webSiteUrl;
  public $avatorImage;
  public $email;
  public $status;
  public $gamePackageIds;
  public $createdAt;
  public $players;
  public $role;

  public function __construct(User $source)
  {
    $this->id = $source->getId()->getValue();
    $this->name = $source->getName()->getValue();
    $this->steamId = $source->getSteamId()->getValue();
    $this->twitterId = $source->getTwitterId()->getValue();
    $this->webSiteUrl = $source->getWebSiteUrl()->getValue();
    $this->avatorImage = $source->getAvatorImage()->getImageFullPath();
    $this->email = $source->getEmail()->getValidEmail();
    $this->status = $source->getStatus()->getEnumName();
    $this->gamePackageIds = $source->getGamePackageIds()->getList();
    $this->createdAt = $source->getCreatedAt()->getDatetime();

    $this->players = [];
    foreach ($source->getPlayers() as $player) {
      $this->players[] = [
        'id' => $player->getPlayerId()->getValue(),
        'userId' => $player->getUserId()->getValue(),
        'gamePackageId' => $player->getGamePackageId()->getValue(),
        'name' => $player->getPlayerName()->getValue(),
        'mu' => $player->getMu()->getValue(),
        'sigma' => $player->getSigma()->getValue(),
        'minRate' => $player->getMinRate()->getValue(),
        'maxRate' => $player->getMaxRate()->getValue(),
        'win' => $player->getWin()->getValue(),
        'defeat' => $player->getDefeat()->getValue(),
        'draw' => $player->getGameDraw(),
        'games' => $player->getGames()->getValue(),
        'wp' => $player->getGameWinningPercentage(),
        'lastGameAt' => $player->getLastGameAt()->getDatetime(),
        'enabled' => $player->getEnabled()->getValue(),
      ];
    }

    $this->role = [
      'id' => $source->getRole()->getRoleId()->getValue(),
      'name' => $source->getRole()->getRoleName()->getValue(),
      'level' => $source->getRole()->getRoleLevel()->getValue(),
    ];
  }
}