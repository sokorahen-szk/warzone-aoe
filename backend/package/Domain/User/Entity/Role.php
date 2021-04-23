<?php

namespace Package\Domain\User\Entity;

use Package\Domain\User\ValueObject\Role\RoleId;
use Package\Domain\User\ValueObject\Role\RoleName;
use Package\Domain\User\ValueObject\Role\RoleLevel;

class Role {
  private $roleId;
  private $roleName;
  private $roleLevel;

  public function __construct(
    ?RoleId $roleId,
    RoleName $roleName,
    ?RoleLevel $roleLevel
  ) {
    $this->roleId = $roleId;
    $this->roleName = $roleName;
    $this->roleLevel = $roleLevel;
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
