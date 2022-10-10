<?php declare(strict_types=1);

namespace Package\Usecase\Game\TeamDivision;

use Package\Usecase\Data;

class GameTeamDivisionData extends Data
{
    public $divisions = [];

    public function __construct($source)
    {
        $this->divisions = array_merge($this->divisions, $this->teams($source->team1, 1));
        $this->divisions = array_merge($this->divisions, $this->teams($source->team2, 2));

        $this->divisions['quality'] = $source->victoryPrediction->getPerInt();
    }

    private function teams(array $players, int $teamNumber): array
    {
        $t = sprintf("team%d", $teamNumber);
        $tRankSum = sprintf("team%dMuSum", $teamNumber);

        $data = [
            $t          => [],
            $tRankSum   => 0,
        ];

        foreach ($players as $player) {
            $data[$t][] = [
                'id' => $player->getPlayerId()->getValue(),
                'name' => $player->getPlayerName()->getValue(),
                'mu' => $player->getMu()->getValueAsInt(),
            ];

            $data[$tRankSum] += $player->getMu()->getValueAsInt();
        }

        return $data;
    }
}
