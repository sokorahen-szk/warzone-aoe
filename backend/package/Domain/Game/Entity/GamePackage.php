<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\System\ValueObject\Description;
use Package\Domain\System\ValueObject\Name;

class GamePackage extends Resource {
  protected $gamePackageId;
  protected $description;
  protected $name;

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
   * @return Description|null
   */
  public function getDescription(): ?Description
  {
    return $this->description;
  }

  /**
   * @return Name|null
   */
  public function getName(): ?Name
  {
    return $this->name;
  }

}