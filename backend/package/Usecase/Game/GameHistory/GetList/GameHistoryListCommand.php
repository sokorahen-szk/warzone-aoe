<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameHistory\GetList;

class GameHistoryListCommand {
  public $page;
  public $limit;
  public $gamePackageId;
  public $beginDate;
  public $endDate;

  public function __construct(
    int $page,
	  int $limit,
    int $gamePackageId,
    ?string $beginDate,
    ?string $endDate
  )
  {
    $this->page = $page;
    $this->limit = $limit;
    $this->gamePackageId = $gamePackageId;
    $this->beginDate = $beginDate;
    $this->endDate = $endDate;
  }
}