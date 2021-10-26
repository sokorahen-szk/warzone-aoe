<?php declare(strict_types=1);

namespace Package\Application\Game\TeamDivision;

use Package\Usecase\Game\TeamDivision\GameTeamDivisionServiceInterface;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionCommand;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionData;
use Package\Domain\Game\Exceptions\AlreadyMatchingGamingException;
use Package\Domain\Game\Exceptions\SelectePlayerDuplicateException;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

use Package\Domain\User\Service\PlayerServiceInterface;
use Package\Domain\Game\Service\GameRecordServiceInterface;

use Exception;

class GameTeamDivisionService implements GameTeamDivisionServiceInterface
{
	private $gameRecordService;
	private $playerService;
	private $trueSkillClient;

	public function __construct(
		GameRecordServiceInterface $gameRecordService,
		PlayerServiceInterface $playerService
	)
	{
		$this->gameRecordService = $gameRecordService;
		$this->playerService = $playerService;

		// TODO: 今後RepositoryからTrueSkillのデータ取り出すように包括するかもしれない
		$this->trueSkillClient = new TrueSkillClient();
	}

    public function handle(GameTeamDivisionCommand $command): GameTeamDivisionData
	{
		if ($this->playerService->isDuplicatePlayer($command->playerIds)) {
			throw new SelectePlayerDuplicateException('選択されたユーザが重複しています。');
		}

		if ($this->gameRecordService->isAlreadyMatchingGaming($command->playerIds)) {
			throw new AlreadyMatchingGamingException('ゲーム中のユーザは選択できません。');
		}

		$selectedPlayers = $this->playerService->selectedPlayers($command->playerIds);

		if (count($selectedPlayers) < 2) {
			// TODO: 独自Exception化する
			throw new Exception('選択プレイヤー数は2人以上である必要があります。');
		}

		$trueSkilRequestData = ['players' => $selectedPlayers];
		$trueSkillResponse = $this->trueSkillClient->teamDivisionPattern($trueSkilRequestData);

		return new GameTeamDivisionData($trueSkillResponse);
	}
}