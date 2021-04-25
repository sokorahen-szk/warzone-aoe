<?php declare(strict_types=1);

namespace Package\Application\Player\GetList;

use Package\Usecase\Player\GetList\PlayerGetListServiceInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Usecase\Player\GetList\PlayerData;

class PlayerGetListService implements PlayerGetListServiceInterface {
  private $userRepository;

  public function __construct(PlayerRepositoryInterface $playerRepository)
  {
    $this->playerRepository = $playerRepository;
  }

  public function handle(): PlayerData
  {
    $players = $this->playerRepository->list();
    if (is_null($players)) {
        return null;
    }
    return new PlayerData($players);
  }
}