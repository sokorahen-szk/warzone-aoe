<?php declare(strict_types=1);

namespace Package\Application\Game\Matching;

use Package\Usecase\Game\Matching\GameMatchingCommand;
use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\User\Repository\PlayerRepositoryInterface;
use Package\Infrastructure\TrueSkill\TrueSkillClient;
use Package\Usecase\Game\Matching\GameMatchingServiceInterface;

use Package\Domain\User\Service\PlayerServiceInterface;
use Package\Domain\Game\Service\GameRecordServiceInterface;

class GameMatchingService implements GameMatchingServiceInterface
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

    public function handle(GameMatchingCommand $command): void
	{
		//
	}
}