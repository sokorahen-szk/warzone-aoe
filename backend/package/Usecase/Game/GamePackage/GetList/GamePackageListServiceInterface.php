<?php declare(strict_types=1);

namespace Package\Usecase\Game\GamePackage\GetList;

use Package\Usecase\Game\GamePackage\GetList\GamePackageData;

interface GamePackageListServiceInterface {
  public function handle(): ?GamePackageData;
}