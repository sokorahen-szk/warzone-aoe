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
		  //
      ];
    }

    //$this->gameHistories = $response;
    $this->gameHistories = $sources;
  }
}