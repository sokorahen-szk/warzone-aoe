<?php

namespace Package\Usecase\Player\ListHistory;

use Package\Usecase\Data;

/**
 * Data Transfer Object
 */
class PlayerListHistoryData extends Data
{
	public $playerHistories;

	public function __construct($sources)
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
	}

	private function toPlayerMemories(array $playerMemories): array
	{
	  $list = [];

	  foreach ($playerMemories as $playerMemory) {
		$list[] = [
		  'playerMemoryId'  => $playerMemory->getPlayerMemoryId()->getValue(),
		  'playerId'        => $playerMemory->getplayerId()->getValue(),
		  'team'            => $playerMemory->getTeam()->getValue(),
		  'playerName'      => $playerMemory->getplayer()->getPlayerName()->getValue(),
		  'avatorImage'     => $playerMemory->getplayer()->getUser()->getAvatorImage()->getValue(),
		  'rate'            => $playerMemory->getRate()->getValue(),
		  'afterRate'       => $playerMemory->getAfterRate()->getValue(),
		  'rank'            => $playerMemory->getMu()->getRank(),
		  'afterRank'       => $playerMemory->getAfterMu()->getRank(),
		];
	  }
	  return $list;
	}
}