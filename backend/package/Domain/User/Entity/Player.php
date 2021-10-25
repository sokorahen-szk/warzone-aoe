<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;

use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;
use Package\Domain\User\ValueObject\Player\MinRate;
use Package\Domain\User\ValueObject\Player\MaxRate;
use Package\Domain\User\ValueObject\Player\Win;
use Package\Domain\User\ValueObject\Player\Defeat;
use Package\Domain\User\ValueObject\Player\Games;
use Package\Domain\User\ValueObject\Player\Streak;
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\Enabled;

use Package\Domain\System\ValueObject\Datetime;

class Player extends Resource {
  protected $playerId;
  protected $playerName;
  protected $mu;
  protected $sigma;
  protected $rate;
  protected $minRate;
  protected $maxRate;
  protected $win;
  protected $defeat;
  protected $games;
  protected $streak;
  protected $gamePackages;
  protected $joinedAt;
  protected $lastGameAt;
  protected $enabled;

  public function __construct($data) {
    parent::__construct($data);
  }

  /**
   * @return PlayerId|null
   */
  public function getPlayerId(): ?PlayerId
  {
    return $this->playerId;
  }

  /**
   * @return PlayerName|null
   */
  public function getPlayerName(): ?PlayerName
  {
    return $this->playerName;
  }

  /**
   * @return Mu|null
   */
  public function getMu(): ?Mu
  {
    return $this->mu;
  }

  /**
   * @return Mu
   */
  public function changeMu(Mu $mu): void
  {
    $this->enabled = $mu;
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

  /**
   * @return MinRate|null
   */
  public function getMinRate(): ?MinRate
  {
    return $this->minRate;
  }

  /**
   * @return MaxRate|null
   */
  public function getMaxRate(): ?MaxRate
  {
    return $this->maxRate;
  }

  /**
   * @return Win|null
   */
  public function getWin(): ?Win
  {
    return $this->win;
  }

  /**
   * @return Defeat|null
   */
  public function getDefeat(): ?Defeat
  {
    return $this->defeat;
  }

  /**
   * @return Games|null
   */
  public function getGames(): ?Games
  {
    return $this->games;
  }

  /**
   * @return Streak|null
   */
  public function getStreak(): ?Streak
  {
    return $this->streak;
  }

  /**
   * @return GamePackages|null
   */
  public function getGamePackages(): ?GamePackages
  {
    return $this->gamePackages;
  }

  /**
   * @return Datetime|null
   */
  public function getJoinedAt(): ?Datetime
  {
    return $this->joinedAt;
  }

  /**
   * @return Datetime|null
   */
  public function getLastGameAt(): ?Datetime
  {
    return $this->lastGameAt;
  }

  /**
   * @return Enabled|null
   */
  public function getEnabled(): ?Enabled
  {
    return $this->enabled;
  }

  /**
   * @return Enabled
   */
  public function changeEnabled(Enabled $enabled): void
  {
    $this->enabled = $enabled;
  }

  /**
   * 引き分け数を返す
   * @return int
   */
  public function getGameDraw(): int
  {
    return $this->games->getValue() - ($this->win->getValue() + $this->defeat->getValue());
  }

  /**
   * 勝率を返す
   * @return float
   */
  public function getGameWinningPercentage(): float
  {
    if ($this->win->getValue() < 1) return 0;

    return round(($this->win->getValue() / ($this->games->getValue() - $this->getGameDraw())) * 100, 2);
  }

  /**
   * 勝率を%をつけて返す
   * @return string
   */
  public function getGameWinningPercentageWithPer(): string
  {
    return $this->getGameWinningPercentage() . '%';
  }
}
