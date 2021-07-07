<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\System\ValueObject\Date;
use App\Models\GameRecordModel as EloquentGameRecordModel;

use Package\Domain\Game\ValueObject\GameRecord\GameRecordId;
use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\Game\ValueObject\GameRecord\GameTeam;
use Package\Domain\Game\ValueObject\GameRecord\VictoryPrediction;

use Package\Domain\System\ValueObject\Datetime;
use Package\Domain\User\ValueObject\PlayerMemory\PlayerMemoryId;
use Package\Domain\User\ValueObject\Player\PlayerId;
use Package\Domain\User\ValueObject\Player\Mu;
use Package\Domain\User\ValueObject\Player\Sigma;
use Package\Domain\User\ValueObject\Player\Rate;

use Package\Domain\Game\Entity\GamePackage;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Player;
use Package\Domain\User\Entity\PlayerMemory;
use Package\Domain\Game\Entity\GamePlayerRecord;
use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\User\ValueObject\Player\PlayerName;
use Package\Domain\User\ValueObject\AvatorImage;
use Package\Domain\System\Entity\Paginator;

use Illuminate\Support\Collection;

class GameRecordRepository implements GameRecordRepositoryInterface
{
    /**
    * 特定ユーザのレーティングを日付範囲で取得する
    * @param User $user
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return array<GamePlayerRecord>
    */
    public function listRaitingByUserWithDateRange(User $user, Date $beginDate, ?Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with('player_memories')
            ->whereStartedAtByDateRange($beginDate, $endDate)
            ->whereIn('status', [GameStatus::GAME_STATUS_DRAW, GameStatus::GAME_STATUS_FINISHED])
            ->whereHasByPlayerMemory($user->getPlayer()->getPlayerId())
            ->get();

        if (!$gameRecords) {
            return [];
        }

        $results = [];

        foreach ($gameRecords as $gameRecord) {
            $results[] = $this->toGamePlayerRecord($gameRecord);
        }

        return $results;
    }

    /**
    * 対戦履歴を日付範囲で取得する
    * @param Paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return array<GameRecord>
    */
    public function listHistoryByDateRange(Paginator $paginator, Date $beginDate, Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->orderBy('id', 'DESC')
        ->offset($paginator->getNextOffset())
        ->limit($paginator->getLimit()->getValue())
        ->get();

        if (!$gameRecords) {
            return [];
        }

        $results = [];

        foreach ($gameRecords as $gameRecord) {
            $results[] = $this->toGameRecord($gameRecord);
        }

        return $results;
    }

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得する
    * @param User $user
    * @param Paginator $paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return array<GamePlayerRecord>
    */
    public function listHistoryByUserWithDateRange(User $user, Paginator $paginator, Date $beginDate, Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->orderBy('id', 'DESC')
        ->offset($paginator->getNextOffset())
        ->limit($paginator->getLimit()->getValue())
        ->whereHasByPlayerMemory($user->getPlayer()->getPlayerId())
        ->get();

        if (!$gameRecords) {
            return [];
        }

        $results = [];

        foreach ($gameRecords as $gameRecord) {
            $results[] = $this->toGameRecord($gameRecord);
        }

        return $results;
    }

    /**************************************************
     * PRIVATE
     **************************************************/
    private function toGameRecord($gameRecord): ?GameRecord
    {
        if (!$gameRecord) {
            return null;
        }

        return new GameRecord([
            'gameRecordId'      => new GameRecordId($gameRecord->id),
            'playerMemories'    => $this->toPlayerMemories($gameRecord->player_memories),
            'winningTeam'       => new GameTeam($gameRecord->winning_team),
            'victoryPrediction' => new VictoryPrediction($gameRecord->victory_prediction),
            'status'            => new GameStatus($gameRecord->status),
            'startedAt'         => new Datetime($gameRecord->started_at),
            'finishedAt'        => new Datetime($gameRecord->finished_at),
        ]);
    }

    private function toGamePlayerRecord($gameRecord): ?GamePlayerRecord
    {
        if (!$gameRecord) {
            return null;
        }

        return new GamePlayerRecord([
            'gameRecordId'      => new GameRecordId($gameRecord->id),
            'playerMemory'      => $this->toPlayerMemory($gameRecord->player_memories),
            'gamePackageId'     => new GamePackageId($gameRecord->game_package_id),
            'winningTeam'       => new GameTeam($gameRecord->winning_team),
            'victoryPrediction' => new VictoryPrediction($gameRecord->victory_prediction),
            'status'            => new GameStatus($gameRecord->status),
            'startedAt'         => new Datetime($gameRecord->started_at),
            'finishedAt'        => new Datetime($gameRecord->finished_at),
        ]);
    }

    private function toPlayerMemories($playerMemories): array
    {
        if (!$playerMemories) {
            return [];
        }

        $data = [];

        foreach($playerMemories as $playerMemory) {
            $data[] = $this->toPlayerMemory($playerMemory);
        }

        return $data;
    }

    private function toPlayerMemory($playerMemory): ?PlayerMemory
    {
        if (!$playerMemory) {
            return null;
        }

        if ($playerMemory instanceof Collection) {
            $playerMemory = $playerMemory[0];
        }

        return new PlayerMemory([
            'playerMemoryId'    => new PlayerMemoryId($playerMemory->id),
            'playerId'          => new PlayerId($playerMemory->player_id),
            'player'            => $this->toPlayer($playerMemory->player),
            'team'              => new GameTeam($playerMemory->team),
            'mu'                => new Mu($playerMemory->mu),
            'afterMu'           => new Mu($playerMemory->afterMu),
            'sigma'             => new Sigma($playerMemory->sigma),
            'afterSigma'        => new Sigma($playerMemory->afterSigma),
            'rate'              => new Rate($playerMemory->rate),
            'afterRate'         => new Rate($playerMemory->afterRate),
        ]);
    }

    private function toPlayer($player): ?Player
    {
        if (!$player) {
            return null;
        }

        return new Player([
            'user'       => $this->toUser($player->user),
            'playerName' => new PlayerName($player->name)
        ]);
    }

    private function toUser($user): ?User
    {
        if (!$user) {
            return null;
        }

        return new User([
            'avatorImage' => new AvatorImage($user->avator_image)
        ]);
    }
}
