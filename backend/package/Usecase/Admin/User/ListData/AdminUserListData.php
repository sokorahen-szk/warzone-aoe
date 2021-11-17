<?php

namespace Package\Usecase\Admin\User\ListData;

use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AdminUserListData extends Data {
  public $users;

  public function __construct(array $sources)
  {
      $this->users = [];
  }
}
