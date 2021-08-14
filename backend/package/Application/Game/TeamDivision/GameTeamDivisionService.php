<?php declare(strict_types=1);

namespace Package\Application\Game\TeamDivision;

use Package\Usecase\Game\TeamDivision\GameTeamDivisionServiceInterface;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionCommand;
use Package\Usecase\Game\TeamDivision\GameTeamDivisionData;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\Exceptions\AlreadyMatchingGamingException;
use Package\Domain\Game\Exceptions\SelectePlayerDuplicateException;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Infrastructure\TrueSkill\TrueSkillClient;

class GameTeamDivisionService implements GameTeamDivisionServiceInterface
{
	private $gameRecordRepository;
	private $playerRepository;
	private $trueSkillClient;

	public function __construct(
		GameRecordRepositoryInterface $gameRecordRepository,
		PlayerRepositoryInterface $playerRepository
	)
	{
		$this->gameRecordRepository = $gameRecordRepository;
		$this->playerRepository = $playerRepository;

		// TODO: 今後RepositoryからTrueSkillのデータ取り出すように包括するかもしれない
		$this->trueSkillClient = new TrueSkillClient();
	}

    public function handle(GameTeamDivisionCommand $command): GameTeamDivisionData
	{
		$statusMatching = new GameStatus(GameStatus::GAME_STATUS_MATCHING);
		$matchingGameRecords = $this->gameRecordRepository->listHistoryByStatus($statusMatching);

		if ($this->isDuplicatePlayer($command->playerIds)) {
			throw new SelectePlayerDuplicateException('選択されたユーザが重複しています。');
		}

		if ($this->isAlreadyMatchingGaming($command->playerIds, $matchingGameRecords)) {
			throw new AlreadyMatchingGamingException('ゲーム中のユーザは選択できません。');
		}

		$selectedPlayers = $this->selectedPlayers($command->playerIds);

		$trueSkilRequestData = ['players' => $selectedPlayers];
		$trueSkillResponse = $this->trueSkillClient->teamDivisionPattern($trueSkilRequestData);

		return new GameTeamDivisionData($trueSkillResponse);
	}

	/**
	 * 選択されたプレイヤーIDから、重複して選択されていないかどうか
	 *
	 * @param array $playerIds
	 * @return boolean
	 */
	private function isDuplicatePlayer(array $playerIds): bool
	{
		for ($i = 0; $i < count($playerIds); $i++) {
			for ($j = $i; $j < count($playerIds); $j++) {
				if ($i === $j) continue;
				if ($playerIds[$i] === $playerIds[$j]) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * 選択されたプレイヤーIDから、試合中のユーザが存在するかどうか
	 *
	 * @param array $playerIds
	 * @param array $gameRecords
	 * @return boolean
	 */
	private function isAlreadyMatchingGaming(array $playerIds, array $gameRecords): bool
	{
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

	/**
	 * 選択されたプレイヤーIDから、プレイヤーの情報を取得する
	 *
	 * @param array $playerIds
	 * @return array
	 */
	public function selectedPlayers(array $playerIds): array
	{
		$resource = [];
		foreach ($playerIds as $id) {
			$player = $this->playerRepository->getById(new PlayerId($id));
			$resource[] = [
				'id'	=> $player->getPlayerId()->getValue(),
				'name'	=> $player->getPlayerName()->getValue(),
				'mu'	=> $player->getMu()->getValue(),
				'sigma'	=> $player->getSigma()->getValue(),
			];
		}

		return $resource;
	}
}