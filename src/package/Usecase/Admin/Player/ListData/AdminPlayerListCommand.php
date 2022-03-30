<?php declare(strict_types=1);

namespace Package\Usecase\Admin\Player\ListData;

class AdminPlayerListCommand {
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