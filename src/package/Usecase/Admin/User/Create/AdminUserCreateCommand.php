<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\Create;

class AdminUserCreateCommand {
  public $userName;
  public $playerName;
  public $roleId;
  public $password;
  public $gamePackages;
  public $steamId;

  public function __construct(
    string $userName,
    string $playerName,
    int $roleId,
    string $password,
    ?string $gamePackages,
    ?string $steamId
  )
  {
    $this->userName = $userName;
    $this->playerName = $playerName;
    $this->roleId = $roleId;
    $this->password = $password;
    $this->gamePackages = $gamePackages;
    $this->steamId = $steamId;
  }
}