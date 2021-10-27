<?php declare(strict_types=1);

namespace Package\Application\Game\GameRule\GetList;

use Package\Domain\Game\Repository\GameRuleRepositoryInterface;
use Package\Usecase\Game\GameRule\GetList\GameRuleListData;
use Package\Usecase\Game\GameRule\GetList\GameRuleListServiceInterface;

class GameRuleListService implements GameRuleListServiceInterface
{
    private $gameRuleRepository;

    public function __construct(
        GameRuleRepositoryInterface $gameRuleRepository
    ) {
        $this->gameRuleRepository = $gameRuleRepository;
    }

    public function handle(): GameRuleListData
    {
        $gameRules = $this->gameRuleRepository->list();

        return new GameRuleListData($gameRules);
    }
}
