<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

use Package\Usecase\Data;

class GameHistoryListData extends Data {
  public $gameHistories;
  public $gameHistoryTotalCount;

  public function __construct(array $sources, int $count)
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

    $this->gameHistories = $response;
    $this->gameHistoryTotalCount = $count;
  }

  private function toPlayerMemories(array $sources): array
  {
    $list = [];

    foreach ($sources as $source) {
      $list[] = [
        'playerMemoryId'  => $source->getPlayerMemoryId()->getValue(),
        'playerId'        => $source->getplayerId()->getValue(),
        'team'            => $source->getTeam()->getValue(),
        'playerName'      => $source->getplayer()->getPlayerName()->getValue(),
        'avatorImage'     => $source->getplayer()->getUser()->getAvatorImage()->getValue(),
        'rate'            => $source->getRate()->getValue(),
        'afterRate'       => $source->getAfterRate()->getValue(),
        'rank'            => $source->getMu()->getRank(),
        'afterRank'       => $source->getAfterMu()->getRank(),
      ];
    }
    return $list;
  }
}