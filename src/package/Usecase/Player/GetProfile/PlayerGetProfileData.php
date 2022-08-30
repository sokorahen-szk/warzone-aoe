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
	public $player;
	public $steamUrl;
	public $twitterUrl;
	public $webSiteUrl;
	public $avatorImage;
	public $status;

	public function __construct(User $source)
	{
		$this->id = $source->getId()->getValue();
		$this->steamUrl = $source->getSteamId()->getFullUrl();
		$this->twitterUrl = $source->getTwitterId()->getFullUrl();
		$this->webSiteUrl = $source->getWebSiteUrl()->getValue();
		$this->avatorImage = $source->getAvatorImage()->getImageFullPath();
		$this->status = $source->getStatus()->getEnumName();

		$this->player = [
		  'id' 				=> $source->getPlayer()->getPlayerId()->getValue(),
		  'name' 			=> $source->getPlayer()->getPlayerName()->getValue(),
		  'sigma'    		=> $source->getPlayer()->getSigma()->getValue(),
		  'mu'    			=> $source->getPlayer()->getMu()->getValueAsInt(),
		  'minRate' 		=> $source->getPlayer()->getMinRate()->getValue(),
		  'maxRate' 		=> $source->getPlayer()->getMaxRate()->getValue(),
		  'win' 			=> $source->getPlayer()->getWin()->getValue(),
		  'defeat' 			=> $source->getPlayer()->getDefeat()->getValue(),
		  'draw' 			=> $source->getPlayer()->getGameDraw(),
		  'games' 			=> $source->getPlayer()->getGames()->getValue(),
		  'wp' 				=> $source->getPlayer()->getGameWinningPercentage(),
		  'gamePackages' 	=> $source->getPlayer()->getGamePackages()->getList(),
		  'joinedAt' 		=> $source->getPlayer()->getJoinedAt()->getDatetime(),
		  'lastGameAt' 		=> $source->getPlayer()->getLastGameAt()->getDatetime(),
		];

	}
}