<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\Id as GamePackageId;
use Package\Domain\Game\ValueObject\Description as GamePackageDescription;
use Package\Domain\Game\ValueObject\Name as GamePackageName;

class GamePackage extends Resource {
  protected $gamePackageId;
  protected $gamePackageDescription;
  protected $gamePackageName;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return GamePackageId|null
   */
  public function getGamePackageId(): ?GamePackageId
  {
    return $this->gamePackageId;
  }

  /**
   * @return GamePackageDescription|null
   */
  public function getGamePackageDescription(): ?GamePackageDescription
  {
    return $this->gamePackageDescription;
  }

  /**
   * @return GamePackageName|null
   */
  public function getGamePackageName(): ?GamePackageName
  {
    return $this->gamePackageName;
  }

}