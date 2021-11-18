<?php

namespace Package\Usecase\Admin\User\ListData;

use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AdminUserListData extends Data {
  public $users = [];

  public function __construct(array $sources)
  {
      foreach ($sources as $source) {
        $this->users[] = [
          'id' => $source->getId()->getValue(),
          'name' => $source->getName()->getValue(),
          'email' => $source->getEmail()->getValue(),
          'status' => $source->getStatus()->getValue(),
          'statusAsEnumName' => $source->getStatus()->getEnumName(),
          'steamId' => $source->getSteamId()->getValue(),
          'twitterId' => $source->getTwitterId()->getValue(),
          'webSiteUrl' => $source->getWebSiteUrl()->getValue(),
          'role' => [
            'id' => $source->getRole()->getRoleId()->getValue(),
            'name' => $source->getRole()->getRoleName()->getValue(),
          ],
          'player' => [
            'status' => $source->getPlayer()->getEnabled()->getValue(),
            'joinedAt' => $source->getPlayer()->getJoinedAt()->getDatetime(),
            'lastGameAt' => $source->getPlayer()->getLastGameAt()->getDatetime(),
          ],
        ];
      }
  }
}
