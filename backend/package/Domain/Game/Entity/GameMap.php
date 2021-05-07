<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\Id as GameMapId;
use Package\Domain\Game\ValueObject\Id as GamePackageId;
use Package\Domain\Game\ValueObject\Name as GameMapName;
use Package\Domain\Game\ValueObject\GameMap\Image;
use Package\Domain\Game\ValueObject\Description as GamePackageDescription;

class GameMap extends Resource {
  protected $gameMapId;
  protected $gamePackageId;
  protected $gameMapName;
  protected $image;
  protected $gameMapDescription;

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
   * @return GameMapName|null
   */
  public function getGameMapName(): ?GameMapName
  {
    return $this->gameMapName;
  }

  /**
   * @return Image|null
   */
  public function getImage(): ?Image
  {
    return $this->image;
  }

  /**
   * @return GamePackageDescription|null
   */
  public function getGamePackageDescription(): ?GamePackageDescription
  {
    return $this->gameMapDescription;
  }

}