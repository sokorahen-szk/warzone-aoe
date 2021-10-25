<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PlayerModel;

class RegisterRequestModel extends Model
{
    use HasFactory;

    protected $table = 'register_requests';

    public $timestamps = false;

    protected $guarded = [];

    public function player()
    {
        return $this->belongsTo(PlayerModel::class, 'player_id');
    }

     // プレイヤーを紐付け
     public function scopeLeftJoinPlayer($query)
     {
         return $query->leftJoin('players', 'register_requests.player_id', '=', 'players.id');
     }
}
