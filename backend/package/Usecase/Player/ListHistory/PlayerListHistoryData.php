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
			'winningTeam'         => $source->getWinningTeam()->getValue(),
			'victoryPrediction'   => $source->getVictoryPrediction()->getValue(),
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
		  'playerId'        => $playerMemory->getPlayerId()->getValue(),
		  'team'            => $playerMemory->getTeam()->getValue(),
		  'playerName'      => $playerMemory->getPlayer()->getPlayerName()->getValue(),
		  'avatorImage'     => $playerMemory->getUser()->getAvatorImage()->getValue(),
		  'rate'            => $playerMemory->getRate()->getValue(),
		  'afterRate'       => $playerMemory->getAfterRate()->getValue(),
		  'rank'            => $playerMemory->getMu()->getRank(),
		  'afterRank'       => $playerMemory->getAfterMu()->getRank(),
		];
	  }
	  return $list;
	}
}