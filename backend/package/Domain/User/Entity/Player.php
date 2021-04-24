<?php

namespace Package\Domain\User\Entity;

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
use Package\Domain\User\ValueObject\Player\GamePackages;
use Package\Domain\User\ValueObject\Player\Datetime;
use Package\Domain\User\ValueObject\Player\Enabled;

class Player {
  private $playerId;
  private $playerName;
  private $mu;
  private $sigma;
  private $rate;
  private $minRate;
  private $maxRate;
  private $win;
  private $defeat;
  private $games;
  private $gamePackages;
  private $joinedAt;
  private $lastGameAt;
  private $enabled;
  public function __construct(
    ?PlayerId $playerId,
    PlayerName $playerName,
    Mu $mu,
    Sigma $sigma,
    Rate $rate,
    MinRate $minRate,
    MaxRate $maxRate,
    Win $win,
    Defeat $defeat,
    Games $games,
    ?GamePackages $gamePackages,
    Datetime $joinedAt,
    ?Datetime $lastGameAt,
    Enabled $enabled
  ) {
    $this->playerId = $playerId;
    $this->playerName = $playerName;
    $this->mu = $mu;
    $this->sigma = $sigma;
    $this->minRate = $minRate;
    $this->maxRate = $maxRate;
    $this->win = $win;
    $this->defeat = $defeat;
    $this->games = $games;
    $this->gamePackages = $gamePackages;
    $this->joinedAt = $joinedAt;
    $this->lastGameAt = $lastGameAt;
    $this->enabled = $enabled;
  }


  /**
   * @return PlayerId|null
   */
  public function getPlayerId(): ?PlayerId
  {
    return $this->playerId;
  }

  /**
   * @return PlayerName
   */
  public function getPlayerName(): PlayerName
  {
    return $this->playerName;
  }

  /**
   * @return Mu
   */
  public function getMu(): Mu
  {
    return $this->mu;
  }

  /**
   * @return Sigma
   */
  public function getSigma(): Sigma
  {
    return $this->sigma;
  }

  /**
   * @return Rate
   */
  public function getRate(): Rate
  {
    return $this->rate;
  }

  /**
   * @return MinRate
   */
  public function getMinRate(): MinRate
  {
    return $this->minRate;
  }

  /**
   * @return MaxRate
   */
  public function getMaxRate(): MaxRate
  {
    return $this->maxRate;
  }

  /**
   * @return Win
   */
  public function getWin(): Win
  {
    return $this->win;
  }

  /**
   * @return Defeat
   */
  public function getDefeat(): Defeat
  {
    return $this->defeat;
  }

  /**
   * @return Games
   */
  public function getGames(): Games
  {
    return $this->games;
  }

  /**
   * @return GamePackages|null
   */
  public function getGamePackages(): ?GamePackages
  {
    return $this->gamePackages;
  }

  /**
   * @return Datetime
   */
  public function getJoinedAt(): Datetime
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
   * @return Enabled
   */
  public function getEnabled(): Enabled
  {
    return $this->enabled;
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
    return round(($this->win->getValue() / ($this->games->getValue() - $this->getGameDraw())) * 100, 2);
  }

}
