<?php

namespace Package\Usecase\Player\GetProfile;

use Package\Usecase\Data;
use Package\Domain\User\Entity\User;

/**
 * Data Transfer Object
 */
class PlayerGetProfileData extends Data
{
	public $id;
	public $name;
	public $steamUrl;
	public $twitterUrl;
	public $webSiteUrl;
	public $avatorImage;
	public $status;
	public $createdAt;

	public $players;

	public function __construct(User $source)
	{
		$this->id = $source->getId()->getValue();
		$this->name = $source->getName()->getValue();
		$this->steamUrl = $source->getSteamId()->getFullUrl();
		$this->twitterUrl = $source->getTwitterId()->getFullUrl();
		$this->webSiteUrl = $source->getWebSiteUrl()->getValue();
		$this->avatorImage = $source->getAvatorImage()->getImageFullPath();
		$this->status = $source->getStatus()->getEnumName();
		$this->createdAt = $source->getCreatedAt()->getDatetime();

		$this->players = [];
		foreach ($source->getPlayers() as $player) {
		$this->players[] = [
			'id' 			=> $player->getPlayerId()->getValue(),
			'userId'		=> $player->getUserId()->getValue(),
			'name' 			=> $player->getPlayerName()->getValue(),
			'rank'    		=> $player->getMu()->getRank(),
			'minRate' 		=> $player->getMinRate()->getValue(),
			'maxRate' 		=> $player->getMaxRate()->getValue(),
			'win' 			=> $player->getWin()->getValue(),
			'defeat' 		=> $player->getDefeat()->getValue(),
			'draw' 			=> $player->getGameDraw(),
			'games' 		=> $player->getGames()->getValue(),
			'wp' 			=> $player->getGameWinningPercentage(),
			'gamePackageId' => $player->getGamePackageId()->getValue(),
			'lastGameAt' 	=> $player->getLastGameAt()->getDatetime(),
		  ];
		}
	}
}