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

class PlayerMemory extends Resource {
  protected $playerMemoryId;
  protected $playerId;
  protected $gameRecordId;
  protected $team;
  protected $mu;
  protected $sigma;
  protected $rate;

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
   * @return Sigma|null
   */
  public function getSigma(): ?Sigma
  {
    return $this->sigma;
  }

  /**
   * @return Rate|null
   */
  public function getRate(): ?Rate
  {
    return $this->rate;
  }

}