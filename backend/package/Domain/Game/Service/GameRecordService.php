<?php declare(strict_types=1);

namespace Package\Domain\Game\Service;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;

class GameRecordService implements GameRecordServiceInterface
{
    private $gameRecordRepository;

    public function __construct(GameRecordRepositoryInterface $gameRecordRepository)
    {
        $this->gameRecordRepository = $gameRecordRepository;
    }

	/**
	 * 選択されたプレイヤーIDから、試合中のユーザが存在するかどうか
	 *
	 * @param array $playerIds
	 * @return boolean
	 */
	public function isAlreadyMatchingGaming(array $playerIds): bool
	{
		$statusMatching = new GameStatus(GameStatus::GAME_STATUS_MATCHING);
		$gameRecords = $this->gameRecordRepository->listHistoryByStatus($statusMatching);

		$checkDuplicate = false;
		foreach($gameRecords as $gameRecord) {
			if (!$gameRecord) continue;
			foreach ($gameRecord->getPlayerMemories() as $playerMemory) {
				if (array_search($playerMemory->getPlayerId()->getValue(), $playerIds) !== false) {
					$checkDuplicate = true;
					break;
				}
			}

			if ($checkDuplicate) {
				break;
			}
		}

		return $checkDuplicate;
	}
}