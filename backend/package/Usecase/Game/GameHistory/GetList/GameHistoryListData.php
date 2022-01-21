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

  private function toPlayerMemories(array $sources): array
  {
    $list = [];

    foreach ($sources as $source) {
      $list[] = [
        'playerMemoryId'  => $source->getPlayerMemoryId()->getValue(),
        'userId'          => $source->getUser()->getId()->getValue(),
        'playerId'        => $source->getPlayerId()->getValue(),
        'team'            => $source->getTeam()->getValue(),
        'playerName'      => $source->getPlayer()->getPlayerName()->getValue(),
        'avatorImage'     => $source->getUser()->getAvatorImage()->getValue(),
        'rate'            => $source->getRate()->getValue(),
        'afterRate'       => $source->getAfterRate()->getValue(),
        'rank'            => $source->getMu()->getRank(),
        'afterRank'       => $source->getAfterMu()->getRank(),
      ];
    }
    return $list;
  }
}