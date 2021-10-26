<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerModel extends Model
{
    protected $table = 'players';

    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    // ユーザ情報
    public function user()
    {
        return $this->hasOne(UserModel::class, 'player_id', 'id');
    }
}
