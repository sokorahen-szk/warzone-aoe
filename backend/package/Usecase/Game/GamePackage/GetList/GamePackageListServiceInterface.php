<?php declare(strict_types=1);

namespace Package\Usecase\Game\GamePackage\GetList;

interface GamePackageListServiceInterface {
  public function handle(): PlayerData;
}