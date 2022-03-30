<?php

namespace Package\Usecase\Admin\Player\ListData;

use Package\Domain\System\Entity\ApiPaginator;
use Package\Usecase\Data;

/**
 * Data Transfer Object
 */

class AdminPlayerListData extends Data {
  public $players = [];
	public $paginator;

  public function __construct(array $sources, ApiPaginator $apiPaginator)
  {
      foreach ($sources as $source) {
        $this->users[] = [
          'id' => $source->getPlayerId()->getValue(),
          'avatorImage' => $source->getUser()->getAvatorImage()->getImageFullPath(),
          'name' => $source->getPlayerName()->getValue(),
          'rate' => $source->getRate()->getValue(),
          'rank' => $source->getMu()->getRank(),
          'mu' => $source->getMu()->getValue(),
          'sigma' => $source->getSigma()->getValue(),
          'gamePackages' => $source->getGamePackages()->getList(),
          'enabled' => $source->getEnabled()->getValue(),
        ];
      }

      $this->paginator = $apiPaginator->getPaginator();
  }
}
