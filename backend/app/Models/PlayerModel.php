<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerModel extends Model
{
    protected $table = 'players';

    protected $guarded = [];

    // ユーザ情報
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
