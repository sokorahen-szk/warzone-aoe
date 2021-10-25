<?php

namespace Package\Domain\User\Entity;

use Package\Domain\Resource;

use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Role\RoleName;
use Package\Domain\User\ValueObject\Role\RoleLevel;

class Role extends Resource {
  protected $roleId;
  protected $roleName;
  protected $roleLevel;

  public function __construct($data) {
    parent::__construct($data);
  }

  /**
   * @return RoleId|null
   */
  public function getRoleId(): ?RoleId
  {
    return $this->roleId;
  }

  /**
   * @return RoleName|null
   */
  public function getRoleName(): ?RoleName
  {
    return $this->roleName;
  }

  /**
   * @return RoleLevel|null
   */
  public function getRoleLevel(): ?RoleLevel
  {
    return $this->roleLevel;
  }
}
