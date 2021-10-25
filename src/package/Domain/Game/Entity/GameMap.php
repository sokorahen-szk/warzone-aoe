<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\System\ValueObject\Name;
use Package\Domain\Game\ValueObject\GameMap\Image;
use Package\Domain\System\ValueObject\Description;

class GameMap extends Resource {
  protected $gameMapId;
  protected $gamePackageId;
  protected $name;
  protected $image;
  protected $description;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return GameMapId|null
   */
  public function getGameMapId(): ?GameMapId
  {
    return $this->gameMapId;
  }

  /**
   * @return GamePackageId|null
   */
  public function getGamePackageId(): ?GamePackageId
  {
    return $this->gamePackageId;
  }

  /**
   * @return Name|null
   */
  public function getName(): ?Name
  {
    return $this->name;
  }

  /**
   * @return Image|null
   */
  public function getImage(): ?Image
  {
    return $this->image;
  }

  /**
   * @return Description|null
   */
  public function getDescription(): ?Description
  {
    return $this->description;
  }

}