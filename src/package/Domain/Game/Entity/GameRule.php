<?php

namespace Package\Domain\Game\Entity;

use Package\Domain\Resource;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\System\ValueObject\Name;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\System\ValueObject\Description;

class GameRule extends Resource {
  protected $gameRuleId;
  protected $gamePackageId;
  protected $name;
  protected $description;

  public function __construct($data)
  {
    parent::__construct($data);
  }

  /**
   * @return GameRuleId|null
   */
  public function getGameRuleId(): ?GameRuleId
  {
    return $this->gameRuleId;
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
   * @return Description|null
   */
  public function getDescription(): ?Description
  {
    return $this->description;
  }

}