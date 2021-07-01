<?php

namespace Package\Domain\System\Entity;

use Package\Domain\Resource;
use Package\Domain\System\ValueObject\Page;
use Package\Domain\System\ValueObject\Limit;

class Paginator extends Resource {
  protected $page;
  protected $limit;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return Page
   */
  public function getPage(): Page
  {
    return $this->page;
  }

  /**
   * @return Limit
   */
  public function getLimit(): Limit
  {
    return $this->limit;
  }
}