<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

class GameHistoryListCommand {
  public $page;
  public $limit;
  public $beginDate;
  public $endDate;

  public function __construct(
    int $page,
	  int $limit,
    ?string $beginDate,
    ?string $endDate
  )
  {
    $this->page = $page;
    $this->limit = $limit;
    $this->beginDate = $beginDate;
    $this->endDate = $endDate;
  }
}