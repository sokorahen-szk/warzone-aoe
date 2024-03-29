<?php declare(strict_types=1);

namespace Package\Application\Game\Matching;

use Package\Infrastructure\TrueSkill\TrueSkillClient;
use Package\Usecase\Game\Matching\GameMatchingServiceInterface;
use Package\Usecase\Game\Matching\GameMatchingData;
use Package\Usecase\Game\Matching\GameMatchingCommand;


use Package\Domain\Game\Exceptions\AlreadyMatchingGamingException;
use Package\Domain\Game\Exceptions\SelectePlayerDuplicateException;
use Package\Domain\User\Service\PlayerServiceInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Domain\User\Repository\PlayerMemoryRepositoryInterface;
use Package\Domain\Game\Service\GameRecordServiceInterface;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\Game\Repository\GameRecordTokenRepositoryInterface;
use Package\Domain\Game\Repository\GamePackageRepositoryInterface;
use Package\Domain\Game\Repository\GameMapRepositoryInterface;
use Package\Domain\Game\Repository\GameRuleRepositoryInterface;
use Package\Infrastructure\Discord\DiscordRepositoryInterface;

use Package\Domain\User\ValueObject\UserId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;
use Package\Domain\Game\ValueObject\GameRecord\IsRating;

use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\System\ValueObject\Datetime;

use Package\Domain\User\Entity\Player;

use Exception;
use DB;

class GameMatchingService implements GameMatchingServiceInterface
{
	private $gameRecordService;
	private $playerService;
	private $playerRepository;
	private $playerMemoryRepository;
	private $trueSkillClient;
	private $gameRecordRepository;
	private $gameRecordTokenRepository;
	private $gamePackageRepository;
	private $gameMapRepository;
	private $gameRuleRepository;
	private $discordRepository;

	public function __construct(
		GameRecordServiceInterface $gameRecordService,
		PlayerServiceInterface $playerService,
		PlayerRepositoryInterface $playerRepository,
		PlayerMemoryRepositoryInterface $playerMemoryRepository,
		GameRecordRepositoryInterface $gameRecordRepository,
		GameRecordTokenRepositoryInterface $gameRecordTokenRepository,
		GamePackageRepositoryInterface $gamePackageRepository,
		GameMapRepositoryInterface $gameMapRepository,
		GameRuleRepositoryInterface $gameRuleRepository,
		DiscordRepositoryInterface $discordRepository
	)
	{
		$this->gameRecordService = $gameRecordService;
		$this->playerService = $playerService;
		$this->playerRepository = $playerRepository;
		$this->playerMemoryRepository = $playerMemoryRepository;
		$this->gameRecordRepository = $gameRecordRepository;
		$this->gameRecordTokenRepository = $gameRecordTokenRepository;
		$this->gamePackageRepository = $gamePackageRepository;
		$this->gameMapRepository = $gameMapRepository;
		$this->gameRuleRepository = $gameRuleRepository;

		$this->discordRepository = $discordRepository;

		// TODO: 今後RepositoryからTrueSkillのデータ取り出すように包括するかもしれない
		$this->trueSkillClient = new TrueSkillClient();
	}

    public function handle(GameMatchingCommand $command): GameMatchingData
	{
		if ($this->playerService->isDuplicatePlayer($command->playerIds)) {
			throw new SelectePlayerDuplicateException('選択されたユーザが重複しています。');
		}

		if ($this->gameRecordService->isAlreadyMatchingGaming($command->playerIds)) {
			throw new AlreadyMatchingGamingException('ゲーム中のユーザは選択できません。');
		}

		$players = $this->playerService->playerIdsToPlayerEntities($command->playerIds);
		if (count($players) != 8) {
			// TODO: 独自Exception化する
			throw new Exception('選択プレイヤー数は8人である必要があります。');
		}

		$gamePaackageId = new GamePackageId($command->gamePackageId);
		$this->gamePackageRepository->get($gamePaackageId);

		$gameMapId = new GameMapId($command->mapId);
		$this->gameMapRepository->get($gameMapId);

		$gameRuleId = new GameRuleId($command->ruleId);
		$this->gameRuleRepository->get($gameRuleId);

		$trueSkillRequest = $this->toTrueSkillAsDivisionPatternRequest($players);
		$trueSkillResponse = $this->trueSkillClient->teamDivisionPattern($trueSkillRequest);

		$team1Players = $this->toPlayers($trueSkillResponse->team1);
		$team2Players = $this->toPlayers($trueSkillResponse->team2);

		$userId = null;
		if ($command->userId) {
			$userId = new UserId($command->userId);
		}
		$victoryPrediction = new VictoryPrediction($trueSkillResponse->quality);

		$expiresAt = new Datetime(now());
		$expiresAt->addHours(6); // トークンの有効期限は6時間

		$isRating = new IsRating($command->isRating);

		try {
			DB::beginTransaction();

			$gameRecordId = $this->gameRecordRepository->create(
				$userId,
				$gamePaackageId,
				$gameMapId,
				$gameRuleId,
				$victoryPrediction,
				$isRating
			);

			$this->createPlayerMemories($team1Players, $gameRecordId, new GameTeam(1));
			$this->createPlayerMemories($team2Players, $gameRecordId, new GameTeam(2));

			$gameRecordToken = $this->gameRecordTokenRepository->create($gameRecordId, $expiresAt);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			throw $e;
		}

		// TODO: 今後ここは、Discord通知を非同期で行うようにコード修正する
		$gameRecord = $this->gameRecordRepository->getById($gameRecordId);
		$this->discordRepository->startGameNotification($gameRecord);

		return new GameMatchingData($gameRecordToken);
	}

	/**
	 * @param object $resources
	 * @return Player[]
	 */
	private function toPlayers($resources): array
	{
		$players = [];
		foreach ($resources as $resource) {
			$players[] = $this->playerRepository->getById(new PlayerId($resource->id));
		}

		return $players;
	}

	/**
	 * @param Player[] $players
	 * @param GameRecordId $gameRecordId
	 * @param GameTeam $gameTeam
	 * @return void
	 */
	private function createPlayerMemories(array $players, GameRecordId $gameRecordId, GameTeam $gameTeam)
	{
		foreach ($players as $player) {
			$this->playerMemoryRepository->create($gameRecordId, $player, $gameTeam);
		}
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
}