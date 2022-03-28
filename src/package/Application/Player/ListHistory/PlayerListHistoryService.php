<?php declare(strict_types=1);

namespace Package\Application\Player\ListHistory;

use Package\Usecase\Player\ListHistory\PlayerListHistoryServiceInterface;
use Package\Usecase\Player\ListHistory\PlayerListHistoryCommand;
use Package\Usecase\Player\ListHistory\PlayerListHistoryData;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Package\Domain\System\Entity\Paginator;
use Package\Domain\System\ValueObject\Date;
use Package\Domain\System\ValueObject\Offset;
use Package\Domain\System\ValueObject\Limit;
use Package\Domain\System\Entity\ApiPaginator;

class PlayerListHistoryService implements PlayerListHistoryServiceInterface {
	private $userRepository;
    private $gameRecordRepository;

	public function __construct(
		UserRepositoryInterface $userRepository,
		GameRecordRepositoryInterface $gameRecordRepository
	)
	{
		$this->userRepository = $userRepository;
		$this->gameRecordRepository = $gameRecordRepository;
	}

	public function handle(PlayerListHistoryCommand $command): PlayerListHistoryData
	{
		$user = $this->userRepository->findUserById(new UserId($command->userId));

		if (!$user) {
			// TODO: ここはException作って対応したい
			throw new \Exception("ユーザが見つかりませんでした。");
		}

		$paginator = new Paginator([
			'offset' 	=> 	new Offset($command->page),
			'limit' 	=>	new Limit($command->limit),
		]);

		$beginDate = new Date($command->beginDate);
		$endDate = new Date($command->endDate);

		$gameRecords = $this->gameRecordRepository->listHistoryByUserWithDateRange(
			$user, $paginator, $beginDate, $endDate
		);

		$gameRecordTotalCount = $this->gameRecordRepository->listHistoryByUserWithDateRangeCount(
			$user, $beginDate, $endDate
		);

		$apiPaginator = new ApiPaginator([
			'currentPage' 	=> $command->page,
			'totalCount' 	=> $gameRecordTotalCount,
			'limit' 		=> $command->limit,
		]);

		return new PlayerListHistoryData($gameRecords, $apiPaginator);
	}
}