<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\System\ValueObject\Datetime;

use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\Game\Entity\User;
use Package\Domain\User\Entity\PlayerMemory;

class GamePlayerRecord extends Resource {
  protected $gameRecordId;
  protected $playerMemory;
  protected $gamePackageId;
  protected $gamePackage;
  protected $userId;
  protected $user;
  protected $winningTeam;
  protected $status;
  protected $startedAt;
  protected $finishedAt;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return GameRecordId|null
   */
  public function getGameRecordId(): ?GameRecordId
  {
    return $this->gameRecordId;
  }

  /**
   * @return PlayerMemory|null
   */
  public function getPlayerMemory(): ?PlayerMemory
  {
    return $this->playerMemory;
  }

  /**
   * @return GamePackageId|null
   */
  public function getGamePackageId(): ?GamePackageId
  {
    return $this->gamePackageId;
  }

  /**
   * @return GamePackage|null
   */
  public function getGamePackage(): ?GamePackage
  {
    return $this->gamePackage;
  }

  /**
   * @return UserId|null
   */
  public function getUserId(): ?UserId
  {
    return $this->userId;
  }

  /**
   * @return User|null
   */
  public function getUser(): ?User
  {
    return $this->user;
  }

  /**
   * @return GameTeam|null
   */
  public function getWinningTeam(): ?GameTeam
  {
    return $this->winningTeam;
  }

  /**
   * @return GameStatus|null
   */
  public function getStatus(): ?GameStatus
  {
    return $this->status;
  }

  /**
   * @return Datetime|null
   */
  public function getStartedAt(): ?Datetime
  {
    return $this->startedAt;
  }

  /**
   * @return Datetime|null
   */
  public function getFinishedAt(): ?Datetime
  {
    return $this->finishedAt;
  }

}