<?php declare(strict_types=1);

namespace Package\Usecase\Account\Register;

class AccountRegisterCommand {
  public $userId;
  public $playerName;
  public $password;
  public $email;
  public $gamePackageIds;
  public $answer1;
  public $answers2;
  public $answers3;

  public function __construct(
    string $userName,
    string $playerName,
    string $password,
    ?string $email,
    string $gamePackageIds,
    ?string $answer1,
    ?string $answers2,
    ?string $answers3
  )
  {
    $this->userName = $userName;
    $this->playerName = $playerName;
    $this->password = $password;
    $this->email = $email;
    $this->gamePackageIds = $gamePackageIds;
    $this->answer1 = $answer1;
    $this->answers2 = $answers2;
    $this->answers3 = $answers3;
  }
}