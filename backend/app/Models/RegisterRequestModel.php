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
}
