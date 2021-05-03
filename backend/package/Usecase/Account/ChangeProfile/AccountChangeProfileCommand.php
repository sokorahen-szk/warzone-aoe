<?php declare(strict_types=1);

namespace Package\Usecase\Account\ChangeProfile;

class AccountChangeProfileCommand {
  public $userId;
  public $userName;
  public $email;
  public $password;
  public $steamId;
  public $twitterId;
  public $webSiteURL;

  public function __construct(
    int $userId,
    string $userName,
    ?string $email,
    ?string $password,
    ?string $steamId,
    ?string $twitterId,
    ?string $webSiteURL
  )
  {
    $this->userId = $userId;
    $this->userName = $userName;
    $this->email = $email;
    $this->password = $password;
    $this->steamId = $steamId;
    $this->twitterId = $twitterId;
    $this->webSiteURL = $webSiteURL;
  }
}