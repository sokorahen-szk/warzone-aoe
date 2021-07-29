<?php declare(strict_types=1);

namespace Package\Application\Game\TeamDivision;

use Package\Usecase\Game\TeamDivision\GameTeamDivisionServiceInterface;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionCommand;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionData;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;

class GameTeamDivisionService implements GameTeamDivisionServiceInterface
{
	private $gameRecordRepository;

	public function __construct(
		GameRecordRepositoryInterface $gameRecordRepository
	)
	{
		$this->gameRecordRepository = $gameRecordRepository;
	}

    public function handle(GameTeamDivisionCommand $command): GameTeamDivisionData
	{
		$statusMatching = new GameStatus(GameStatus::GAME_STATUS_MATCHING);
		$matchingGameRecords = $this->gameRecordRepository->listHistoryByStatus($statusMatching);

		if ($this->checkDuplicatePlayer($command->playerIds, $matchingGameRecords)) {
			// Exception
		}

		// TODO: packageIdのチェック

		// TODO: ルールIDのチェック

		// TODO: マップIDのチェック

		// TODO: trueSkillAPIをコールする

		// 結果を返す
		return new GameTeamDivisionData([]);
	}

	private function checkDuplicatePlayer(array $playerIds, array $playerMemories)
	{
		// TODO: 
	}
}