<?php

namespace Package\Usecase\Admin\User\ListData;

use Package\Domain\System\Entity\ApiPaginator;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AdminUserListData extends Data {
  public $users = [];
	public $paginator;

  public function __construct(array $sources, ApiPaginator $apiPaginator)
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
          'avatorImage' => $source->getAvatorImage()->getImageFullPath(),
          'role' => [
            'id' => $source->getRole()->getRoleId()->getValue(),
            'name' => $source->getRole()->getRoleName()->getValue(),
          ],
          'player' => [
            'status' => $source->getPlayer()->getEnabled()->getValue(),
            'joinedAt' => $source->getPlayer()->getJoinedAt()->getDatetime(),
            'lastGameAt' => $source->getPlayer()->getLastGameAt()->getDatetime(),
            'gamePackages' => $source->getPlayer()->getGamePackages()->getList(),
          ],
        ];
      }

      $this->paginator = $apiPaginator->getPaginator();
  }
}
