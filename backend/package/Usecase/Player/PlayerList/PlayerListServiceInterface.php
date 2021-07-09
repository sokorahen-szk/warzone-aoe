<?php declare(strict_types=1);

namespace Package\Usecase\Player\PlayerList;

interface PlayerListServiceInterface {
  public function handle(): PlayerListData;
}