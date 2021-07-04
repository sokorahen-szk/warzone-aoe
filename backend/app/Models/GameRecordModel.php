<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlayerMemoryModel;
use App\Models\GamePackageModel;
use Package\Domain\System\ValueObject\Date;
use Package\Domain\Game\ValueObject\GameRecord\GameStatus;
use Package\Domain\User\ValueObject\Player\PlayerId;

class GameRecordModel extends Model
{
    use HasFactory;

    protected $table = 'game_records';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * 個別情報を結合する
     *
     * @param $query
     * @return Eloquent
     */
    public function scopeLeftJoinPlayerMemories($query)
    {
        return $query->leftJoin('player_memories', "{$this->table}.id", '=', 'player_memories.game_record_id');
    }

    /**
     * 開始と終了日付で抽出する
     *
     * @param $query
     * @param Date $beginDate
     * @param Date $endDate
     * @return Eloquent
     */
    public function scopeWhereStartedAtByDateRange($query, Date $beginDate, Date $endDate)
    {
        if (!$beginDate->isNull() && !$endDate->isNull()) {
            $query = $query->whereBetween('started_at', [$beginDate->getDateFormatYYYYMMDDForBegin(), $endDate->getDateFormatYYYYMMDDForEnd()]);
        }
        return $query;
    }

    /**
     * ステータスが試合終了のデータを抽出する
     *
     * @param $query
     * @return Eloquent
     */
    public function scopeWhereStatusByFinished($query)
    {
        return $query->where('status', GameStatus::GAME_STATUS_FINISHED);
    }

    /**
     * プレイヤーIDで抽出する
     *
     * @param $query
     * @param PlayerId $playerId
     * @return void
     */
    public function scopeWhereHasByPlayerMemory($query, PlayerId $playerId)
    {
        return $query->whereHas('player_memories', function($query) use ($playerId) {
            $query->where('player_id', $playerId->getValue());
        });
    }

    /**
     * ################################################
     * リレーション
     * ################################################
     */

    // ゲームパッケージ
    public function game_package()
    {
        return $this->hasOne(GamePackageModel::class, 'id', 'game_package_id');
    }

    // ルール
    public function rule()
    {
        return $this->hasOne(RuleModel::class, 'id', 'game_package_id');
    }

    // マップ
    public function map()
    {
        return $this->hasOne(MapModel::class, 'id', 'map_id');
    }

    // ゲームパッケージ
    public function player_memories()
    {
        return $this->hasMany(PlayerMemoryModel::class, 'game_record_id', 'id');
    }
}
