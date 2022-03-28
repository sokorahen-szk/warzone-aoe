<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

use Package\Usecase\Data;
use Package\Domain\System\Entity\ApiPaginator;

class GameHistoryListData extends Data {
  public $gameHistories;
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
        'gameMap' => [
          'id'                      => $source->getGameMap()->getGameMapId()->getValue(),
          'name'                    => $source->getGameMap()->getName()->getValue(),
        ],
        'gameRule' => [
          'id'                      => $source->getGameRule()->getGameRuleId()->getValue(),
          'name'                    => $source->getGameRule()->getName()->getValue(),
        ],
        'playerMemories'      => $this->toPlayerMemories($source->getPlayerMemories()),
        'playerCount'         => count($source->getPlayerMemories()),
        'winningTeam'         => $source->getWinningTeam()->getValue(),
        'victoryPrediction'   => $source->getVictoryPrediction()->getValue(),
        'status'              => $source->getGameStatus()->getValue(),
        'startedAt'           => $source->getStartedAt()->getDatetime(),
        'finishedAt'          => $source->getFinishedAt()->getDatetime(),
      ];
    }

    $this->gameHistories = $response;
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
        'rate'            => $playerMemory->getRate()->getValue(),
        'afterRate'       => $playerMemory->getAfterRate()->getValue(),
        'rank'            => $playerMemory->getMu()->getRank(),
        'afterRank'       => $playerMemory->getAfterMu()->getRank(),
      ];
    }
    return $list;
  }
}