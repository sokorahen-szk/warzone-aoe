<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\User\Entity\PlayerMemory;
use Package\Domain\Game\Entity\GamePackage;

use Package\Domain\System\ValueObject\Datetime;

class GameRecord extends Resource {
	protected $gameRecordId;
	protected $gamePackageId;
	protected $gamePackage;
	protected $playerMemories;
	protected $userId;
	protected $ruleId;
	protected $mapId;
	protected $winningTeam;
	protected $victoryPrediction;
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
	 * @return array<PlayerMemory>|null
	 */
	public function getPlayerMemories(): ?array
	{
		return $this->playerMemories;
	}

	/**
	 * @return UserId|null
	 */
	public function getUserId(): ?UserId
	{
		return $this->userId;
	}

	/**
	 * @return GameRuleId|null
	 */
	public function getGameRuleId(): ?GameRuleId
	{
		return $this->ruleId;
	}

	/**
	 * @return GameMapId|null
	 */
	public function getGameMapId(): ?GameMapId
	{
		return $this->mapId;
	}

	/**
	 * @return GameTeam|null
	 */
	public function getWinningTeam(): ?GameTeam
	{
		return $this->winningTeam;
	}

	/**
	 * @return VictoryPrediction|null
	 */
	public function getVictoryPrediction(): ?VictoryPrediction
	{
		return $this->victoryPrediction;
	}

	/**
	 * @return GameStatus|null
	 */
	public function getGameStatus(): ?GameStatus
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