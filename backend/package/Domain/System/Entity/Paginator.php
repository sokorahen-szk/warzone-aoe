<?php

namespace Package\Domain\System\Entity;

use Package\Domain\Resource;
use Package\Domain\System\ValueObject\Offset;
use Package\Domain\System\ValueObject\Limit;

class Paginator extends Resource {
  protected $offset;
  protected $limit;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return Offset
   */
  public function getOffset(): Offset
  {
    return $this->offset;
  }

  /**
   * @return Limit
   */
  public function getLimit(): Limit
  {
    return $this->limit;
  }

  /**
   * データをpaginatorで取り出す時に、offset + page計算する
   * @return int
   */
  public function getNextOffset(): int
  {
    $offset = $this->offset->getValue();
    $limit = $this->limit->getValue();
    return $offset * $limit;
  }
}