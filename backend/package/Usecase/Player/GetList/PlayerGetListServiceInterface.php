<?php declare(strict_types=1);

namespace Package\Usecase\Player\GetList;
use Package\Usecase\Player\GetList\PlayerData;

interface PlayerGetListServiceInterface {
  public function handle(): PlayerData;
}