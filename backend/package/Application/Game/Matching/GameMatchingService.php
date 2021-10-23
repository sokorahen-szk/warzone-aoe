<?php declare(strict_types=1);

namespace Package\Application\Game\Matching;

use Package\Usecase\Game\Matching\GameMatchingCommand;
use Package\Infrastructure\TrueSkill\TrueSkillClient;
use Package\Usecase\Game\Matching\GameMatchingServiceInterface;

use Package\Domain\Game\Exceptions\AlreadyMatchingGamingException;
use Package\Domain\Game\Exceptions\SelectePlayerDuplicateException;

use Package\Domain\User\Service\PlayerServiceInterface;
use Package\Domain\Game\Service\GameRecordServiceInterface;
use Package\Domain\Game\Repository\GamePackageRepositoryInterface;
use Package\Domain\Game\Repository\GameMapRepositoryInterface;
use Package\Domain\Game\Repository\GameRuleRepositoryInterface;

use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameMap\GameMapId;
use Package\Domain\Game\ValueObject\GameRule\GameRuleId;

class GameMatchingService implements GameMatchingServiceInterface
{
	private $gameRecordService;
	private $playerService;
	private $trueSkillClient;
	private $gamePackageRepository;
	private $gameMapRepository;
	private $gameRuleRepository;

	public function __construct(
		GameRecordServiceInterface $gameRecordService,
		PlayerServiceInterface $playerService,
		GamePackageRepositoryInterface $gamePackageRepository,
		GameMapRepositoryInterface $gameMapRepository,
		GameRuleRepositoryInterface $gameRuleRepository
	)
	{
		$this->gameRecordService = $gameRecordService;
		$this->playerService = $playerService;
		$this->gamePackageRepository = $gamePackageRepository;
		$this->gameMapRepository = $gameMapRepository;
		$this->gameRuleRepository = $gameRuleRepository;

		// TODO: 今後RepositoryからTrueSkillのデータ取り出すように包括するかもしれない
		$this->trueSkillClient = new TrueSkillClient();
	}

    public function handle(GameMatchingCommand $command): void
	{
		if ($this->playerService->isDuplicatePlayer($command->playerIds)) {
			throw new SelectePlayerDuplicateException('選択されたユーザが重複しています。');
		}

		if ($this->gameRecordService->isAlreadyMatchingGaming($command->playerIds)) {
			throw new AlreadyMatchingGamingException('ゲーム中のユーザは選択できません。');
		}

		$gamePaackageId = new GamePackageId($command->gamePackageId);
		$this->gamePackageRepository->get($gamePaackageId);

		$gameMapId = new GameMapId($command->mapId);
		$this->gameMapRepository->get($gameMapId);

		$gameRuleId = new GameRuleId($command->ruleId);
		$this->gameRuleRepository->get($gameRuleId);
	}
}