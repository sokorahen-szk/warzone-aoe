<?php declare(strict_types=1);

namespace Package\Usecase\Game\GamePackage\GetList;

use Package\Usecase\Data;

class GamePackageData extends Data {
  public $gamePackages;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'id'          => $source->getGamePackageId()->getValue(),
        'description' => $source->getDescription()->getValue(),
        'name'        => $source->getName()->getValue(),
      ];
    }

    $this->gamePackages = $response;
  }
}