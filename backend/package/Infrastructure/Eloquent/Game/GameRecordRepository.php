<?php declare(strict_types=1);

namespace Package\Infrastructure\Eloquent\Game;

use Package\Domain\Game\Repository\GameRecordRepositoryInterface;
use Package\Domain\System\ValueObject\Date;
use App\Models\GameRecordModel as EloquentGameRecordModel;

use Package\Domain\Game\ValueObject\GamePackage\GamePackageId;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\User\Entity\User;
use Package\Domain\User\Entity\Player;
use Package\Domain\Game\Entity\GamePlayerRecord;
use Package\Domain\Game\Entity\GameRecord;
use Package\Domain\System\Entity\Paginator;

use Package\Infrastructure\Eloquent\Converter;

class GameRecordRepository implements GameRecordRepositoryInterface
{
    /**
    * 特定ユーザのレーティングを日付範囲で取得する
    * @param User $user
    * @param GamePackageId $gamePackageId
    * @param Date $beginDate
    * @param Date|null $endDate
    * @return GamePlayerRecord[]
    */
    public function listRaitingByUserWithDateRange(User $user, GamePackageId $gamePackageId, Date $beginDate, ?Date $endDate): array
    {
        $players = $user->getPlayers();
        $player = $this->filterPlayersByGamePackageId($players, $gamePackageId);

        // userが持っているplayer情報がない場合、そのまま返す。
        if (!$player) {
            return [];
        }

        $gameRecords = EloquentGameRecordModel::with('player_memory')
            ->whereStartedAtByDateRange($beginDate, $endDate)
            ->whereIn('status', [GameStatus::GAME_STATUS_DRAW, GameStatus::GAME_STATUS_FINISHED])
            ->whereHasByPlayerMemory($player->getPlayerId())
            ->get();

        if (!$gameRecords) {
            return [];
        }

        return Converter::gamePlayerRecords($gameRecords);
    }

    /**
    * 対戦履歴を日付範囲で取得する
    * @param GamePackageId $gamePackageId
    * @param Paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GameRecord[]
    */
    public function listHistoryByDateRange(GamePackageId $gamePackageId, Paginator $paginator, Date $beginDate, Date $endDate): array
    {
        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->where('game_package_id', $gamePackageId->getValue())
        ->orderBy('id', 'DESC')
        ->offset($paginator->getNextOffset())
        ->limit($paginator->getLimit()->getValue())
        ->get();

        if (!$gameRecords) {
            return [];
        }

        return Converter::gameRecords($gameRecords);
    }

    /**
    * 対戦履歴を日付範囲で取得し、総件数を返す
    * @param GamePackageId $gamePackageId
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByDateRangeCount(GamePackageId $gamePackageId, Date $beginDate, Date $endDate): int
    {
        $count = EloquentGameRecordModel::whereStartedAtByDateRange($beginDate, $endDate)
        ->where('game_package_id', $gamePackageId->getValue())
        ->count();

        return $count;
    }

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得する
    * @param User $user
    * @param GamePackageId $gamePackageId
    * @param Paginator $paginator
    * @param Date $beginDate
    * @param Date $endDate
    * @return GamePlayerRecord[]
    */
    public function listHistoryByUserWithDateRange(User $user, GamePackageId $gamePackageId, Paginator $paginator, Date $beginDate, Date $endDate): array
    {
        $player = $this->filterPlayersByGamePackageId($user->getPlayers(), $gamePackageId);

        // userが持っているplayer情報がない場合、そのまま返す。
        if (!$player) {
            return [];
        }

        $gameRecords = EloquentGameRecordModel::with([
            'game_package',
            'player_memories.player.user',
            'map',
            'rule',
        ])
        ->where('game_package_id', $gamePackageId->getValue())
        ->whereStartedAtByDateRange($beginDate, $endDate)
        ->whereHasByPlayerMemories($player->getPlayerId())
        ->orderBy('id', 'DESC')
        ->offset($paginator->getNextOffset())
        ->limit($paginator->getLimit()->getValue())
        ->get();

        return Converter::gameRecords($gameRecords);
    }

    /**
    * 特定ユーザの対戦履歴を日付範囲で取得し、総件数を返す
    * @param User $user
    * @param GamePackageId $gamePackageId
    * @param Date $beginDate
    * @param Date $endDate
    * @return int
    */
    public function listHistoryByUserWithDateRangeCount(User $user, GamePackageId $gamePackageId, Date $beginDate, Date $endDate): int
    {
        $player = $this->filterPlayersByGamePackageId($user->getPlayers(), $gamePackageId);

        // userが持っているplayer情報がない場合、そのまま返す。
        if (!$player) {
            return [];
        }

        $count = EloquentGameRecordModel::whereStartedAtByDateRange($beginDate, $endDate)
        ->whereHasByPlayerMemories($player->getPlayerId())
        ->where('game_package_id', $gamePackageId->getValue())
        ->count();

        return $count;
    }

    /**
     * 特定のステータスでデータを抽出する
     * @param GameStatus $status
     * @return GamePlayerRecord[]
     */
    public function listHistoryByStatus(GameStatus $status): array
    {
        $gameRecords = EloquentGameRecordModel::with('player_memories')
        ->where('status', $status->getValue())
        ->get();

        return Converter::gameRecords($gameRecords);
    }

    /**************************************************
     * PRIVATE
     **************************************************/

    /**
     * @param Player[] $players
     * @param GamePackageId $id
     * @return Player|null
     */
    private function filterPlayersByGamePackageId(array $players, GamePackageId $gamePackageId): ?Player
    {
        foreach($players as $player) {
            if ($player->getGamePackageId()->equal($gamePackageId)) {
                return $player;
            }
        }
        return null;
    }
}
