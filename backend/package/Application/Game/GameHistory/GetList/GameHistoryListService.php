<?php declare(strict_types=1);

namespace Package\Application\Game\GameHistory\GetList;

use Package\Usecase\Game\GameHistory\GetList\GameHistoryListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListData;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListCommand;
use Package\Domain\System\Entity\Paginator;

class GameHistoryListService implements GameHistoryListServiceInterface {
	public function __construct()
	{
		//
	}

	public function handle(GameHistoryListCommand $command): ?GameHistoryListData
	{
		$paginator = new Paginator([
			'page' 		=> 	$command->page,
			'limit' 	=>	$command->limit,
		]);

		return new GameHistoryListData([]);
	}
}