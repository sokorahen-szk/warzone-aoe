<?php declare(strict_types=1);

namespace Package\Usecase\Admin\User\Update;

/*
            $request->input('password', null),
            $request->input('steam_id', null),
            $request->input('twitter_id', null),
            $request->input('web_site_url', null),
            $request->input('status', null)
*/


class AdminUserUpdateCommand {
  public $userId;
  public $userName;
  public $email;
  public $password;
  public $steamId;
  public $twitterId;
  public $webSiteUrl;
  public $status;

  public function __construct(
    int $userId,
    string $userName,
    ?string $email,
    ?string $password,
    ?string $steamId,
    ?string $twitterId,
    ?string $webSiteUrl,
    ?int $status
  )
  {
    $this->userId = $userId;
    $this->userName = $userName;
    $this->email = $email;
    $this->password = $password;
    $this->steamId = $steamId;
    $this->twitterId = $twitterId;
    $this->webSiteUrl = $webSiteUrl;
    $this->status = $status;
  }
}