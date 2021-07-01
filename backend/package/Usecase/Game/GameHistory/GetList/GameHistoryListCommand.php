<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

class GameHistoryListCommand {
  public $page;
  public $limit;

  public function __construct(
    int $page,
	  int $limit
  )
  {
    $this->page = $page;
    $this->limit = $limit;
  }
}