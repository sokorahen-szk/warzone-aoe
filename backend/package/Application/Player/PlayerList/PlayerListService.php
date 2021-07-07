<?php declare(strict_types=1);

namespace Package\Application\Player\PlayerList;

use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Usecase\Player\PlayerList\PlayerListData;
use Package\Usecase\Player\PlayerList\PlayerListServiceInterface;

class PlayerListService implements PlayerListServiceInterface {
  private $playerRepository;

  public function __construct(PlayerRepositoryInterface $playerRepository)
  {
    $this->playerRepository = $playerRepository;
  }

  public function handle(): PlayerListData
  {
    $players = $this->playerRepository->list();
    if (is_null($players)) {
        return null;
    }
    return new PlayerListData($players);
  }
}