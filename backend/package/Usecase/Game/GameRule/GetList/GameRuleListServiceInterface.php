<?php declare(strict_types=1);

namespace Package\Usecase\Game\GameRule\GetList;

interface GameRuleListServiceInterface
{
    public function handle(): GameRuleListData;
}
