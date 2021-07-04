<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

use Package\Usecase\Data;

class GameHistoryListData extends Data {
  public $gameHistories;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'gameRecordId'        => $source->getGameRecordId()->getValue(),
        'playerMemories'      => $this->toPlayerMemories($source->getPlayerMemories()),
        'winningTeam'         => $source->getWinningTeam()->getValue(),
        'victoryPrediction'   => $source->getVictoryPrediction()->getValue(),
        'status'              => $source->getGameStatus()->getValue(),
        'startedAt'           => $source->getStartedAt()->getDatetime(),
        'finishedAt'          => $source->getFinishedAt()->getDatetime(),
      ];
    }

    $this->gameHistories = $response;
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