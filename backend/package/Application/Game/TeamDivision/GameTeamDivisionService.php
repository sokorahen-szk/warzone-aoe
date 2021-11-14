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
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;

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

		$players = $this->playerService->playerIdsToPlayerEntities($command->playerIds);
		if (count($players) < 2) {
			// TODO: 独自Exception化する
			throw new Exception('選択プレイヤー数は2人以上である必要があります。');
		}

		// TODO: このあたりリファクタしたい
		$trueSkillRequest = $this->toTrueSkillAsDivisionPatternRequest($players);
		$trueSkillResponse = $this->trueSkillClient->teamDivisionPattern($trueSkillRequest);

		$team1 = $this->trueSkillResponseFromPlayersToPlayerEntities($trueSkillResponse->team1, $players);
		$team2 = $this->trueSkillResponseFromPlayersToPlayerEntities($trueSkillResponse->team2, $players);

		return new GameTeamDivisionData((object) [
			'victoryPrediction' => new VictoryPrediction($trueSkillResponse->quality),
			'team1' => $team1,
			'team2' => $team2,
		]);
	}

	// TODO: 今後、TrueSkillのRequest/Response作ったらそっちに移動する予定。
	private function toTrueSkillAsDivisionPatternRequest(array $players): array
	{
		$data = [];
		foreach ($players as $player) {
			$data[] = [
				'id'	=> $player->getPlayerId()->getValue(),
				'name'	=> $player->getPlayerName()->getValue(),
				'mu'	=> $player->getMu()->getValue(),
				'sigma'	=> $player->getSigma()->getValue(),
			];
		}

		return ['players' => $data];
	}

	private function trueSkillResponseFromPlayersToPlayerEntities($trueSkillResponseFromPlayers, array $players): array
	{
		$resource = [];
		foreach ($trueSkillResponseFromPlayers as $trueSkillResponseFromPlayer) {
			foreach ($players as $player) {
				if ($trueSkillResponseFromPlayer->id === $player->getPlayerId()->getValue()) {
					$resource[] = $player;
				}
			}
		}
		return $resource;
	}
}