<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameMap\GetList;

use Package\Usecase\Data;

class GameMapData extends Data {
  public $gameMaps;

  public function __construct(array $sources)
  {
    $response = [];
    foreach ($sources as $source) {
      $response[] = [
        'id'              => $source->getGameMapId()->getValue(),
        'gamePackageId'   => $source->getGamePackageId()->getValue(),
        'name'            => $source->getGameMapName()->getValue(),
        'image'           => $source->getImage()->getValue(),
        'description'     => $source->getGamePackageDescription()->getValue(),
      ];
    }

    $this->gameMaps = $response;
  }
}