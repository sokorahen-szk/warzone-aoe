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
        'description' => $source->getGamePackageDescription()->getValue(),
        'name'        => $source->getGamePackageName()->getValue(),
      ];
    }

    $this->gamePackages = $response;
  }
}