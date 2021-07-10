<?php declare(strict_types=1);

namespace Package\Application\Game\GameHistory\GetList;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListServiceInterface;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListData;
use Package\Usecase\Game\GameHistory\GetList\GameHistoryListCommand;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\System\ValueObject\Date;
use Package\Domain\System\ValueObject\Offset;
use Package\Domain\System\ValueObject\Limit;

class GameHistoryListService implements GameHistoryListServiceInterface {
    private $gameRecordRepository;

	public function __construct(GameRecordRepositoryInterface $gameRecordRepository)
	{
		$this->gameRecordRepository = $gameRecordRepository;
	}

	public function handle(GameHistoryListCommand $command): ?GameHistoryListData
	{
		$paginator = new Paginator([
			'offset' 	=> 	new Offset($command->page),
			'limit' 	=>	new Limit($command->limit),
		]);

		$beginDate = new Date($command->beginDate);
		$endDate = new Date($command->endDate);

		$gameRecords = $this->gameRecordRepository->listHistoryByDateRange(
			$paginator, $beginDate, $endDate
		);

		$gameRecordTotalCount = $this->gameRecordRepository->listHistoryByDateRangeCount($beginDate, $endDate);

		return new GameHistoryListData($gameRecords, $gameRecordTotalCount);
	}
}