<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRule\GetList;

use Package\Usecase\Data;

class GameRuleListData extends Data {
  public $gameRules;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'id'              => $source->getGameRuleId()->getValue(),
        'gamePackageId'   => $source->getGamePackageId()->getValue(),
        'name'            => $source->getName()->getValue(),
        'description'     => $source->getDescription()->getValue(),
      ];
    }

    $this->gameRules = $response;
  }
}