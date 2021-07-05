<?php declare(strict_types=1);

namespace Package\Application\Player\GetHistory;

use Package\Usecase\Player\GetHistory\PlayerGetHistoryServiceInterface;
use Package\Usecase\Player\GetHistory\PlayerGetHistoryCommand;
use Package\Usecase\Player\GetHistory\PlayerGetHistoryData;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;

class PlayerGetHistoryService implements PlayerGetHistoryServiceInterface {
    private $gameRecordRepository;

	public function __construct(GameRecordRepositoryInterface $gameRecordRepository)
	{
		$this->gameRecordRepository = $gameRecordRepository;
	}

	public function handle(PlayerGetHistoryCommand $command): PlayerGetHistoryData
	{
		return new PlayerGetHistoryData([]);
	}
}