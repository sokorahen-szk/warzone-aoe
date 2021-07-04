<?php declare(strict_types=1);

namespace Package\Application\Game\GameHistory\GetList;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListData;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListCommand;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\System\ValueObject\Date;

class GameHistoryListService implements GameHistoryListServiceInterface {
    private $gameRecordRepository;

	public function __construct(GameRecordRepositoryInterface $gameRecordRepository)
	{
		$this->gameRecordRepository = $gameRecordRepository;
	}

	public function handle(GameHistoryListCommand $command): ?GameHistoryListData
	{
		$paginator = new Paginator([
			'page' 		=> 	$command->page,
			'limit' 	=>	$command->limit,
		]);

		$beginDate = new Date($command->beginDate);
		$endDate = new Date($command->endDate);

		$gameRecords = $this->gameRecordRepository->listHistoryByDateRange(
			$paginator, $beginDate, $endDate
		);

		return new GameHistoryListData($gameRecords);
	}
}