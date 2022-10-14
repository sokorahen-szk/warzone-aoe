<?php

namespace Package\Usecase\Player\ListHistory;

use Package\Usecase\Data;
use Package\Domain\System\Entity\ApiPaginator;

/**
 * Data Transfer Object
 */
class PlayerListHistoryData extends Data
{
	public $playerHistories;
	public $paginator;

	public function __construct(array $sources, ApiPaginator $apiPaginator)
	{
		$response = [];
		foreach ($sources as $source) {
			$response[] = [
				'gameRecordId'        => $source->getGameRecordId()->getValue(),
				'gamePackage'         => [
					'id'                      => $source->getGamePackage()->getGamePackageId()->getValue(),
					'name'                    => $source->getGamePackage()->getName()->getValue(),
				],
				'playerMemories'      => $this->toPlayerMemories($source->getPlayerMemories()),
				'playerCount'         => count($source->getPlayerMemories()),
				'winningTeam'         => $source->getWinningTeam()->getValue(),
				'victoryPrediction'   => $source->getVictoryPrediction()->getValue(),
				'isRating'   		  => $source->getIsRating()->getValue(),
				'status'              => $source->getGameStatus()->getValue(),
				'startedAt'           => $source->getStartedAt()->getDatetime(),
				'finishedAt'          => $source->getFinishedAt()->getDatetime(),
			];
		}

		$this->playerHistories = $response;
		$this->paginator = $apiPaginator->getPaginator();
	}

	private function toPlayerMemories(array $playerMemories): array
	{
		$list = [];

		foreach ($playerMemories as $playerMemory) {
			$list[] = [
				'playerMemoryId'  => $playerMemory->getPlayerMemoryId()->getValue(),
				'userId'          => $playerMemory->getUser()->getId()->getValue(),
				'playerId'        => $playerMemory->getPlayerId()->getValue(),
				'team'            => $playerMemory->getTeam()->getValue(),
				'playerName'      => $playerMemory->getPlayer()->getPlayerName()->getValue(),
				'avatorImage'     => $playerMemory->getUser()->getAvatorImage()->getValue(),
				'mu'            	=> $playerMemory->getMu()->getValueAsInt(),
				'afterMu'       	=> $playerMemory->getAfterMu()->getValueAsInt(),
			];
		}

		return $list;
	}
}