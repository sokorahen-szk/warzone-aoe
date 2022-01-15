<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\Update;

class AdminUserUpdateCommand {
  public $userId;
  public $userName;
  public $roleId;
  public $email;
  public $password;
  public $steamId;
  public $twitterId;
  public $webSiteUrl;
  public $status;
  public $gamePackages;

  public function __construct(
    int $userId,
    string $userName,
    int $roleId,
    ?string $email,
    ?string $password,
    ?string $steamId,
    ?string $twitterId,
    ?string $webSiteUrl,
    ?int $status,
    ?string $gamePackages
  )
  {
    $this->userId = $userId;
    $this->userName = $userName;
    $this->roleId = $roleId;
    $this->email = $email;
    $this->password = $password;
    $this->steamId = $steamId;
    $this->twitterId = $twitterId;
    $this->webSiteUrl = $webSiteUrl;
    $this->status = $status;
    $this->gamePackages = $gamePackages;
  }
}