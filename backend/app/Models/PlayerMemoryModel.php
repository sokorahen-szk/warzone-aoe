<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerMemoryModel extends Model
{
    use HasFactory;

    protected $table = 'player_memories';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * ################################################
     * リレーション
     * ################################################
     */

    // プレイヤー
    public function player()
    {
        return $this->hasOne(PlayerModel::class, 'id', 'player_id');
    }
}
