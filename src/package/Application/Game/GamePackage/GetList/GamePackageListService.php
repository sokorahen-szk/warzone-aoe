<?php declare(strict_types=1);

namespace Package\Application\Game\GamePackage\GetList;

use Package\Usecase\Game\GamePackage\GetList\GamePackageListServiceInterface;
use Package\Usecase\Game\GamePackage\GetList\GamePackageData;
use Package\Domain\Game\Repository\GamePackageRepositoryInterface;

class GamePackageListService implements GamePackageListServiceInterface {
  private $gamePackageRepository;

  public function __construct(
    GamePackageRepositoryInterface $gamePackageRepository
  )
  {
    $this->gamePackageRepository = $gamePackageRepository;
  }

  public function handle(): ?GamePackageData
  {
    $gamePackages = $this->gamePackageRepository->list();
    if (is_null($gamePackages)) {
      return null;
    }
    return new GamePackageData($gamePackages);
  }
}