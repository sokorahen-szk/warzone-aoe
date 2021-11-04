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
use Package\Domain\Game\Entity\GameMap;
use Package\Domain\Game\Entity\GameRule;

use Package\Domain\System\ValueObject\Datetime;

class GameRecord extends Resource {
	protected $gameRecordId;
	protected $gamePackageId;
	protected $gamePackage;
	protected $playerMemories;
	protected $userId;
	protected $ruleId;
	protected $rule;
	protected $mapId;
	protected $map;
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
	 * @return PlayerMemory[]|null
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
	 * @return GameRule
	 */
	public function getGameRule(): GameRule
	{
		return $this->rule;
	}

	/**
	 * @return GameMapId|null
	 */
	public function getGameMapId(): ?GameMapId
	{
		return $this->mapId;
	}

	/**
	 * @return GameMap
	 */
	public function getGameMap(): GameMap
	{
		return $this->map;
	}

	/**
	 * @return GameTeam|null
	 */
	public function getWinningTeam(): ?GameTeam
	{
		return $this->winningTeam;
	}

	/**
	 * @param GameTeam $gameTeam
	 */
	public function changeWinningTeam(GameTeam $winningTeam): void
	{
		$this->winningTeam = $winningTeam;
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
	 * @param GameStatus $status
	 */
	public function changeGameStatus(GameStatus $status): void
	{
		$this->status = $status;
	}

	/**
	 * @return bool
	 */
	public function getGameStatusIsMatching(): bool
	{
		return $this->status->isMatching();
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

	/**
	 * @param Datetime
	 */
	public function changeFinishedAt(Datetime $finishedAt): void
	{
		$this->finishedAt = $finishedAt;
	}

	/**
	 * チーム別のレート合計
	 *
	 * @param GameTeam $team
	 * @return int
	 */
	public function getRateSum(GameTeam $team): int
	{
		$sum = 0;
		foreach($this->pluckPlayerMemoriesByTeam($team) as $playerMemory) {
			$sum += $playerMemory->getRate()->getValue();
		}

		return $sum;
	}

	public function pluckPlayerMemoriesByTeam(GameTeam $team): array
	{
		$playerMemories = [];
		foreach($this->playerMemories as $playerMemory) {
			if ($playerMemory->getTeam()->getValue() === $team->getValue()) {
				$playerMemories[] = $playerMemory;
			}
		}

		return $playerMemories;
	}
}
