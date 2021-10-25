<?php declare(strict_types=1);

namespace Package\Usecase\Player\ListHistory;

class PlayerListHistoryCommand
{
  public $userId;
  public $page;
  public $limit;
  public $beginDate;
  public $endDate;

  public function __construct(
    int $userId,
    int $page,
    int $limit,
    ?string $beginDate,
    ?string $endDate
  )
  {
    $this->userId = $userId;
    $this->page = $page;
    $this->limit = $limit;
    $this->beginDate = $beginDate;
    $this->endDate = $endDate;
  }
}
