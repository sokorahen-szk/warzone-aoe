<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;
use Package\Domain\User\ValueObject\PlayerMemory\PlayerMemoryId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\User;

class PlayerMemory extends Resource {
  protected $playerMemoryId;
  protected $playerId;
  protected $player;
  protected $user;
  protected $gameRecordId;
  protected $team;
  protected $mu;
  protected $afterMu;
  protected $sigma;
  protected $afterSigma;
  protected $rate;
  protected $afterRate;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return PlayerMemoryId|null
   */
  public function getPlayerMemoryId(): ?PlayerMemoryId
  {
    return $this->playerMemoryId;
  }

  /**
   * @return PlayerId|null
   */
  public function getPlayerId(): ?PlayerId
  {
    return $this->playerId;
  }

  /**
   * @return Player|null
   */
  public function getPlayer(): ?Player
  {
    return $this->player;
  }

  /**
   * @return User|null
   */
  public function getUser(): ?User
  {
    return $this->user;
  }

  /**
   * @return GameRecordId|null
   */
  public function getGameRecordId(): ?GameRecordId
  {
    return $this->gameRecordId;
  }

  /**
   * @return GameTeam|null
   */
  public function getTeam(): ?GameTeam
  {
    return $this->team;
  }

  /**
   * @return Mu|null
   */
  public function getMu(): ?Mu
  {
    return $this->mu;
  }

  /**
   * @return Mu|null
   */
  public function getAfterMu(): ?Mu
  {
    return $this->afterMu;
  }

  /**
   * @return Sigma|null
   */
  public function getSigma(): ?Sigma
  {
    return $this->sigma;
  }

  /**
   * @return Sigma|null
   */
  public function getAfterSigma(): ?Sigma
  {
    return $this->afterSigma;
  }

  /**
   * @return Rate|null
   */
  public function getRate(): ?Rate
  {
    return $this->rate;
  }

  /**
   * @return Rate|null
   */
  public function getAfterRate(): ?Rate
  {
    return $this->afterRate;
  }

}